---
title: Making Request
description:
extends: _layouts.documentation
section: content
---

# Sending Request {#sending-request}

Telegram bots designed to do a lot of handy operations such as sending messages, media, keyboards, etc.

Here's an example to send a message to a user using `sendMessage()` method:

```php
...
use Telegram\Bot\Api as TelegramBot;

$myBot = new TelegramBot('YOUR_BOT_TOKEN');
$message = $myBot->sendMessage([
  "chat_id" => "RECIPIENT_CHAT_ID",
  "text" => "Hello world!",
]);
```

Or if you're using multi bot support, you can send requests using a specified bot. For more information, head over to [Multi Bot Support]() guide.

```php
...

use Telegram\Bot\BotManager;

$telegram = new BotManager([
  'use' => 'firstBot',    // Default bot setting
  'bots' => [
    'firstBot' => [
      'token' => 'FIRST_BOT_TOKEN',
    ],
    'secondBot' => [
      'token' => 'SECOND_BOT_TOKEN',
    ],
  ],
]);

print_r($telegram->bot('firstBot')->getMe());   // Print out first bot information

print_r($telegram->bot('secondBot')->getMe());  // Print out second bot information

// Do another request with your bots...
```

Go to [API Reference]() page for more detailed information on other methods you can do with your bot.
