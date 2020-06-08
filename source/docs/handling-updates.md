---
title: Handling Updates
description:
extends: _layouts.documentation
section: content
---

# Handling Updates

## Introduction {#introduction}

Every interaction user made with your bot will be called as `Update`. Every [Update](https://core.telegram.org/bots/api#update) will be formatted as JSON-serialized objects.

This page will focus on two fundamentals on how to handle Updates within the SDK:

1. Getting the Updates.
2. Handling the Updates using [Event Listener](#event-listener).

## Getting Updates {#getting-updates}

There are two mutually exclusive ways of receiving updates for your bot — **Long-polling** method and **Webhooks**.

All incoming updates are stored on Telegram's server until the bot receives them either way, but they will not be kept longer than 24 hours.

### Long Polling {#long-polling}

By default, all updates will be stored on Telegram's server until it get processed or expired. By `listen()` method, we fetch unprocessed Updates from Telegram server and mark them as processed along the way.

> **Note**: Long polling won't be available if there's Webhook installed on your bot.

```php
$updates = $telegram->bot('bot')->listen();

foreach ($updates as $update) {
    // Do other things with the update
}
```

All updates processed through `listen()` also will be handled via [Event Listener](#event-listener) which will be explained more below.

### Webhooks {#webhooks}

We highly recommend to use Webhook if you need your bot to process Updates in real time.

> **Important:** In order to setup webhooks, your domain has to be secured with SSL certificate (HTTPS).
>
> If you don't have any HTTPS domain yet, we have prepared additional guide on [Setting up temporary SSL secured domain using ngrok]() to test your webhook locally from your machine.

Open `.env` file and fill your bot token and domain:

```env
TELEGRAM_BOT_TOKEN        = "Your bot token here"       // Your bot token
TELEGRAM_WEBHOOK_DOMAIN   = "https://www.example.com"   // Your secured domain
```

Our [standalone-starter]() comes with handy CLI command to help you setup your webhook.

Simply run on your console:

```bash
$ php telegram setup:webhook
```

You will have `Webhook setup successful!` printed on success.

## Event Listener {#event-listener}

After setting up get updates using either long-polling or webhooks, we can process all incoming updates using Event Listener.

Event Listener will help you fully customize how update should be handled/processed by it's type.

---

For example, create a new Event Listener to listen to message.

Create a new file named `ProcessInbountMessage.php` to `bot/Listeners/` folder:

```php
<?php

namespace Bot\Listeners;

use Telegram\Bot\Events\UpdateEvent;
use Telegram\Bot\Exceptions\TelegramSDKException;

class ProcessInboundMessage
{
    /**
     * Handle the event.
     *
     * @param  UpdateEvent  $event
     *
     * @throws TelegramSDKException
     */
    public function handle(UpdateEvent $event)
    {
        $update = $event->update;
        $bot = $event->bot;

        // Process the inbound photo sent by the user.

        // Reply the user.
        $text = 'Thank you for sending a message!';
        $bot->sendMessage([
            'chat_id' => $update->getMessage()->chat->id,
            'text'    => $text,
        ]);
    }
}
```

Then open `config/telegram.php` file and register our newly created `ProcessInbountMessage` class:

```php
'bots' => [
  'default' => [
      ...
      'listen' => [
          // Example of various events fired.
          'update'        => [],
          'message'       => [
            Bot\Listeners\ProcessInboundMessage::class,   // Our new listener
          ],
      ],
      ...
  ],
],
```

That's it! Now your bot should be replying to every message it's received. You can add more than one Event Listener to handle updates on one event, or other various events.

Here's list of other events that could be handled by the SDK:

> **Table of contents here**
