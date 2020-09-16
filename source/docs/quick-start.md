---
title: Quick start
description: Getting started with Telegram Bot SDK.
extends: _layouts.documentation
section: content
---

# Quick Start {#getting-started}

Telegram Bot SDK is a robust library to integrate Telegram Bot to your project without the hassle!

## Requirements

- PHP >= 7.4
- [Composer](https://getcomposer.org/)
- Telegram Bot Token - If you haven't got one, head to official [@BotFather](https://core.telegram.org/bots#botfather) docs on how to generate one.

## 1. Installation

> We've created starter projects to help you get started. If you're new and don't have an existing project, the starter projects will help you to get started and provide you with the basic idea of how the SDK works.
>
> - For Standalone PHP project: [Standalone Starter](https://github.com/telegram-bot-sdk/standalone-starter)
> - For usage with Laravel Framework: [Laravel Starter](https://github.com/telegram-bot-sdk/laravel-starter)

The recommended way to install the SDK is with [Composer](http://getcomposer.org/). Composer is a dependency management tool for PHP that allows you to declare the dependencies your project needs and installs them into your project. If you don't have Composer installed on your machine, you can check [download guide](https://getcomposer.org/download/) at Composer's official website.

Navigate to your project directory and install `telegram-bot-sdk/telegram-bot-sdk` via composer

```bash
$ composer require telegram-bot-sdk/telegram-bot-sdk
```

Your project structure should look like this:

```
├── composer.json
├── composer.lock
└── vendor
```

## 2. Bot Initiation

Create a new file called `index.php` and paste code below:

```php
<?php

require './vendor/autoload.php';

use Telegram\Bot\Api as TelegramBot;

$telegram = new TelegramBot('YOUR_BOT_TOKEN');
```

So, what we've just done was initiating new `TelegramBot` using our bot token.

## 3. Sending requests

Sending a request using the SDK is pretty straightforward. Let's try retrieving your bot info using new `$telegram` instance we've just created above:

```php


$botInfo = $telegram->getMe();
print_r($botInfo);      // Print out your bot information

// Do other stuff with your bot...
```

Pretty simple right? Here's another example to send a message to telegram user by `chat_id`:

```php
$message = $telegram->sendMessage([
  'chat_id' => 'recipient_chat_id',
  'text' => 'Hello world!',
]);

print_r($message);  // Print out successfully sent message

```

You can do other amazing things, including handling updates, sending stickers, etc.! Go to [API Reference]() page to see all available methods.

## 4. Next Steps

Other crucial parts are [responding to user interactions]() which we refer to as Telegram `Updates`. Incoming updates may contain different types such as texts, stickers, photos or videos, even locations. We also can set up our bot to handle the specific kind of Update and process them differently using Event Listeners.

You can also have multi bot support in case you need more than one bot registered in one project. Head over to [Multi Bot Support]() guide for more details.
