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

> **Note**: We highly recommend you to take a look or use one of the starter projects to understand the basic idea and implementation of the SDK.
>
> - [Standalone project starter template](https://github.com/telegram-bot-sdk/standalone-starter)
> - [Laravel project starter template](https://github.com/telegram-bot-sdk/laravel-starter)

## Getting Updates {#getting-updates}

There are two mutually exclusive ways of receiving updates for your bot — **Long-polling** method and **Webhooks**.

All incoming updates are stored on Telegram's server until the bot receives them either way, but they will not be kept longer than 24 hours.

### Long Polling {#long-polling}

By default, all updates will be stored on Telegram's server until it gets processed or expired. By `listen()` method, we fetch unprocessed Updates from Telegram server and mark them as processed along the way.

> **Note**: Long polling won't be available if there's Webhook installed on your bot.

```php
$updates = $telegram->bot('bot')->listen();

foreach ($updates as $update) {
    // Do other things with the update
}
```

All updates processed through `listen()` also will be handled via [Event Listener](#event-listener) which will be explained more below.

### Webhooks {#webhooks}

Processing updates via Webhook is highly recommended if you need your bot to respond in real-time. Update of every interaction made with your bot will be sent as `HTTP POST` to webhook URL registered to Telegram's server.

> **Important:** In order to set up webhooks, your domain has to be secured with SSL certificate (HTTPS).
>
> If you don't have a HTTPS domain yet, we have prepared an additional guide on [Setting up temporary SSL secured domain using ngrok](#) to test your webhook locally from your machine.

> **Note:** If you're using one of the starter templates, we've covered how to configure Webhooks. The template also provides additional security features such as token validation and more out of the box.

Let's get started by registering your bot's webhook URL to Telegram server. You may also refer to instructions as mentioned in [setWebhook official documentation](https://core.telegram.org/bots/api#setwebhook) for this step.

Open up your browser or HTTP Client and send a request to:

```http
https://api.telegram.org/bot<your_bot_token>/setWebhook?url=<your_secured_webhook_url>
```

You will receive `HTTP 200 Success` status on return. After that, you can listen process any updates directly from your class or function by adding this:

```php
$update = $telegram->listen(true);

// Do something with the update object or let the event listener handle it.
// ...
```

## Event Listener {#event-listener}

After setting up get updates using either long-polling or webhooks, you may process incoming updates using Event Listener.

Event Listener will help you fully customize how Update should be handled or processed by its type (either it's a photo, inline query, or other types of `Update`).

---

For example, we will create a new Event Listener to handle every message sent to our bot.

Create a new file named `ProcessInboundMessage.php` to your working project directory:

```php
<?php

namespace Bot\Listeners; // You may modify namespace according to your project directory

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

        // Or you can do many other operations further down here
    }
}
```

```php
<?php

...

$update = $telegram->listen(true);
$telegram->on('message', ProcessInboundMessage::handle($update));

// Or you can listen to another message type.
// Here's an example to process every message that contains one or more photos
$telegram->on('message.photo', ProcessInboundPhoto::handle($update));

```

---

Here's another example for Event Listener to process incoming Update that contains a photo. Let's take a look at how the SDK break down object type of the incoming Update. In this case, we can assume incoming Update will contain a photo and will have this structure:

```php
├── update_id
├── message     // Message object
  ├── id
  ├── from
  ├── chat
  ├── date
  └── photo     // The message includes a photo object!
```

We can set `message.photo` as our listener key which basically means _"Every **`message`** that contains **`photo`** should be processed by this class."_

```php
<?php

...

$update = $telegram->listen(true);

$telegram->on('message.photo', ProcessInboundPhoto::handle($update));

```

This SDK is built with flexibility and ease of use in mind. You can check the structure of JSON Serialized Object Update sent from Telegram and determine your own listener key. The SDK will smartly classify received updates based on its structure and trigger it if there's an Event Listener class being set.
