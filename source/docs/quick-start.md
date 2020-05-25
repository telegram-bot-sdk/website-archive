---
title: Quick start
description: Getting started with Telegram Bot SDK.
extends: _layouts.documentation
section: content
---

# Quick Start {#getting-started}

This is a robust SDK for making it easy to integrate Telegram Bot for PHP in your Laravel and Lumen applications.

## Requirements
- PHP >=7.4
- Composer
- Telegram Bot API Access Token - Talk to [@BotFather](https://core.telegram.org/bots#botfather) and generate one.

## 1. Installation

> This installation section will only install core SDK library with some basic usage examples.
> For advanced usage with Laravel Framework, head over to [Laravel Guide]() page.

The recommended way to install the SDK is with [Composer](http://getcomposer.org/). Composer is a dependency management tool for PHP that allows you to declare the dependencies your project needs and installs them into your project. If you don't have Composer installed on your machine, you can check [download guide](https://getcomposer.org/download/) at Composer's official website.

```
$ composer require telegram-bot-sdk/telegram-bot-sdk
```

You need to require Composer's autoloader if you want to use the library standalone:

```
<?php
...

require 'vendor/autoload.php'

...
```

You can find out more on how to install Composer, configure autoloading, and other best-practices for defining dependencies at getcomposer.org.

## 2. Making Requests
Making a request using the SDK is pretty straightforward. You just need your `bot token` generated from BotFather and initiate you bot using `Api` class.

Here's an example to get bot information using `getMe()` method:
> telegram.php
```
<?php

require 'vendor/autoload.php';

use Telegram\Bot\Api;

$bot = new Api('your_bot_token');   // Your bot token from BotFather

$info = $bot->getMe();              // Get bot Information
printf($info);
```

Run `telegram.php` file from your command line to see the result. You should have your bot information printed as response.
```
$ php telegram.php
```

Here's other example of sending message to certain user by `chat_id` and `sendMessage()` method:

```
<?php

require 'vendor/autoload.php';

use Telegram\Bot\Api;

$bot = new Api('your_bot_token');   // Your bot token from BotFather

$message = $bot->sendMessage([
  'text' => 'Hello world!',
  'chat_id' => 'recipient_chat_id'
]);

printf('message sent!');
printf($message);
```

Of course, you can many other amazing things including handling updates, sending stickers, etc!