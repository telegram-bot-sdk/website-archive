---
title: Making Request
description:
extends: _layouts.documentation
section: content
---

# Sending Request {#sending-request}

Telegram bots are designed to do a lot of handy operations such as sending messages, media, keyboards, etc. This section will guide you how to make and send a request from your specified bot.

Here's an example to send a message to a user by chaining `sendMessage()` method:

```php
$myBot = $telegram->bot('default');
$message = $myBot->sendMessage([
  "chat_id" => "RECIPIENT_CHAT_ID",
  "text" => "Hello world!",
]);

// Or you can send another message using different bot
$secondBot = $telegram->bot('secondBot');
$anotherMessage = $secondBot->sendMessage([
  "chat_id" => "RECIPIENT_CHAT_ID",
  "text" => "Hola mundo!",
]);
```

Go to [API Reference]() page for more detailed information on other methods you can do with your bot.
