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
- Telegram Bot API Access Token - Talk to [@BotFather](https://core.telegram.org/bots#botfather) and generate one.

## 1. Installation

> For usage with Laravel Framework, head over to [Laravel Guide]() page.

The recommended way to install the SDK is with [Composer](http://getcomposer.org/). Composer is a dependency management tool for PHP that allows you to declare the dependencies your project needs and installs them into your project. If you don't have Composer installed on your machine, you can check [download guide](https://getcomposer.org/download/) at Composer's official website.

<!-- If you are building with fresh project, we highly recommend you to download [Starter Template](https://github.com/telegram-bot-sdk/standalone-starter). To clone and install the Starter Template, simply run from you command line: -->

We also highly recommend you to start with [Standalone Starter Template](https://github.com/telegram-bot-sdk/standalone-starter) to begin the process. To install it to your machine simply run:

```
$ composer create-project telegram-bot-sdk/standalone-starter mybot
```
#### Project Structure

```
.
├── .env - Project environment variable.
├── bootstrap - Bot bootstrapping files.
├── bot - Your bot main files.
│   ├── Commands - Bot commands.
│   ├── Console - CLI console commands.
│   ├── Facades - Bot Facades.
│   ├── Http - Bot controllers.
│   └── Listeners - Event Listeners.
├── config - Config files.
|   └── telegram.php - Your main SDK configuration.
└── public - Public facing files.
    └── index.php - Project index file.
    └── pooling.php - Long-pooling update handler.
    └── webhook.php - Webhook update handler.
```

## 2. Configuration
Copy your `bot_token` received from @BotFather an paste it to `.env` file:
```
TELEGRAM_BOT_TOKEN="Your Bot token here"
...
```

## 3. Making a request
Making a request using the SDK is pretty straightforward. Try run `$ php public/index.php`, you should have your bot information printed in your console:
```
<?php

require dirname(__DIR__).'/bootstrap.php';

// Default bot
$defaultBot = telegram()->getMe();
print_r($defaultBot);      // Print out bot information

...
```


Pretty simple right? Here's other example of sending a message to other telegram user by `chat_id`:

```
$message = telegram()->sendMessage([
  'chat_id' => 'recipient_chat_id',
  'text' => 'Hello world!',
]);

...
```

You can do other amazing things including handling updates, sending stickers, etc! Go to [API Reference]() page to see all available methods.

## 4. Handling updates

> **What are Updates?**
> 
> Every interaction user made with your bot will be called as Update. Every Update will be formatted as JSON-serialized objects.

There are two mutually exclusive ways of handling updates for your bot — by long-polling and Webhooks.
Incoming updates are stored on the server until the bot receives them either way, but they will not be kept longer than 24 hours.

#### Long Polling
Long polling is a way to process Update from Telegram server that doesn't need immediate response. Long polling technique won't be available if there's already webhook setup on the bot.

You can modify and run `public/polling.php` to start proccessing updates:

```
$ php public/polling.php
```

#### Webhook
Go to [Webhooks guide]() if you want to your bot to be responsive and handling updates in real-time.
