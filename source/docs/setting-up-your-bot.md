---
title: Setting Up Your Bot
description:
extends: _layouts.documentation
section: content
---

# Setting Up Your Bot

## Introduction

In this section, we will cover topics about how to set up your Telegram bot SDK into your project. Basically, this SDK use an array which will be implemented to `BotManager` class to fully maximize flexibility and usability of the SDK. This array may contain list of configurations such as list of your bots, managing `Event Listener`, also integrating `Commands` to your bots.

Here's the summary of the topics covered in this page:

- Create bot configuration file
- Registering your bots
- Setting your default bot
- HTTP client configuration
- Managing Telegram Bot commands
- Configuring webhook URL

## Create Bot Configuration File

> **Note:** If you're using one of our starter templates, we've provided a full guide on publishing main SDK configuration files, so you don't have to create them manually.

As mentioned in the introduction section, our bot configuration will be an array used together with `BotManager` class.

Let's navigate to your root project directory and create a file with any name you wanted:

```php
// index.php
<?php
  use Telegram\Bot\BotManager;

  $configuration = [
    'use' => 'foo',
    'bots' => [
      'foo' => [
        'token' => 'YOUR-BOT-TOKEN',
        'listen' => [],
        'commands' => [],
      ],

      // You may register another bot config
      // 'bar' => [
      //   'token' => 'YOUR-BOT-TOKEN',
      // ],
    ],
  ];

  $telegram = new BotManager($configuration);

  // Do other stuff with your bot!
  // return $telegram->bot('foo')->getMe();
  // ...
>
```

## Registering Your Bots

So, since `v3` we've introduced multi-bot support for the SDK. We can add as many bots as we want to `bots` key to the configuration array.

```php
[
  ...,
  'bots' => [
    'foo' => [
      'token' => 'YOUR-BOT-TOKEN',
      'username' => '@foo_bot',
      'commands' => [],
      'listen' => [],
    ],

    // 'bar' => [
    //   'token' => 'YOUR-BOT-TOKEN',
    // ],
  ],
  ...
]
```

|   Key    |                                                          Usage                                                          |  Type  | Required |
| :------: | :---------------------------------------------------------------------------------------------------------------------: | :----: | :------: |
|  token   |                                                 Your Telegram Bot Token                                                 | String |    ✅    |
| username |                                               Your Telegram Bot Username                                                | String |          |
| commands | List of `TelegramCommand::class()`, [`command_groups`](#command_groups), or [`command_repository`](#command_repository) | Array  |          |
|  listen  |                                            List of [Event Listener](#) class                                            | Array  |          |

## Setting your default bot

This configuration for the SDK will come in handy if you only have one bot integrated within your project. For example:

```php
// Instead of specifying bot() for any methods
$telegram->bot('foo')->getMe();

// You could simplify it to
$telegram->getMe();

```

Of course, if you want to have a default bot, first, you need to have at least one bot registered in `bots` key. If you already have one, you can specify any bot as default:

```php
[
 'use' => 'foo',         // You are specifying foo as your default bot
 // 'use' => 'bar',      // Or leave bar config here just in case you changed your mind :)

 'bots' => [
   'foo' => [
     'token' => 'YOUR-BOT-TOKEN',
   ],
   'bar' => [
     'token' => 'YOUR-BOT-TOKEN',
   ],
 ],
 ...
]
```

## HTTP client configuration (Optional)

We use Guzzle under the hood to send requests to Telegram's server from the SDK. You can modify this section as you need. If you don't want to change, feel free to it exclude from your configuration file.

```php
[
  ...
  'http' => [
    'config'  => [],
    'async'   => false,
    'api_url' => 'https://api.telegram.org',
    'client'  => \Telegram\Bot\Http\GuzzleHttpClient::class,
  ],
  ...
]
```

|  Key   |                                                            Usage                                                            |  Type   |                       Default                        |
| :----: | :-------------------------------------------------------------------------------------------------------------------------: | :-----: | :--------------------------------------------------: |
| config | Guzzle HTTP Client [request options](http://docs.guzzlephp.org/en/stable/request-options.html) (For setting proxies, etc.). |  Array  |                         `[]`                         |
| async  |                       When set to `true`, All the requests would be made non-blocking (Asynchronous)                        | Boolean |                       `false`                        |
| async  |                                                    Telegram Base API URL                                                    | String  |               https://api.telegram.org               |
| client |         HTTP Client for the SDK. This should be an instance of `\Telegram\Bot\Contracts\HttpClientInterface::class`         |  Class  | `\Telegram\Bot\Contracts\HttpClientInterface::class` |

## Managing Telegram Bot commands

> **Note**: If you're new to Telegram Command, head over to [Command System]() guide for more detail on how to create one.

Telegram Commands is a flexible way to communicate with your bot. A command must start with '/' symbol and may not be longer than 32 characters.

Let's take a look at our main bot configuration file. We will try to set up a command to `foo` bot. For example, we will implement `/start` command:

```php
[
  ...,
  'bots' => [
    'foo' => [
      'token' => 'YOUR-BOT-TOKEN',
      'commands' => [
        'start' => Path\To\StartCommand::class(),
        // ...
      ],
    ],

    ...
  ],
]
```

The example above is the most basic way to implement a command to your bot. If you have more than one command, we highly recommend you to set up `command_groups` and `command_repository` (which will be explained below).

### Global commands

You can register all the global commands here. Global commands will apply to all the bots in your project and will always be active.

All of command class should extend the `\Telegram\Bot\Commands\Command` class.

|         Key         |                                                             Value                                                              |
| :-----------------: | :----------------------------------------------------------------------------------------------------------------------------: |
| `your_command_name` | Class that extends `\Telegram\Bot\Commands\Command`. Your command name shouldn't start with '/' and longer than 32 characters. |

```php
[
  ...
  'bots' => [
    ...
  ],

  // Set up all your global commands here
  'commands' => [
    'help' => Your\Project\Path\HelpCommand::class,
    'start' => Your\Project\Path\StartCommand::class,
    'foo' => Your\Project\Path\FooCommand::class,
    // and so on...
  ],
]
```

### command_groups {#command_groups}

You can organize a set of commands into groups that can later be reused across your bots.

You can create 4 types of `command_groups`:

1. Using full path to command classes.

```php
[
  'command_groups' => [
    'fooGroup' => [
      \Bot\Commands\Bar::class,
      \Bot\Commands\Baz::class,
    ],
    // ...
  ],
]
```

To implement it to your bot:

```php
[
  ...,
  'bots' => [
    'foo' => [
      'token' => 'YOUR-BOT-TOKEN',
      'commands' => [
        'fooGroup',
      ],
    ],

    ...
  ],
]
```

2. Group using command respository name (see [`command_repository`](#command_repository) section below).

```php
[
  'command_groups' => [
    'fooGroup' => ['bar', 'baz'],  // 'bar' and 'baz' are commands listed in repository
    // ...
  ],
]
```

To implement it to your bot:

```php
[
  ...,
  'bots' => [
    'foo' => [
      'token' => 'YOUR-BOT-TOKEN',
      'commands' => [
        'fooGroup',
      ],
    ],

    ...
  ],
]
```

3. Using other `command_groups` name
   For example, take a look at `all` group:

```php
[
  'command_groups' => [
    'hamGroup' => [
      'foo' => \Bot\Commands\Foo::class,
      'bar' => \Bot\Commands\Bar::class,
    ],
    'all' => [
      'hamGroup',
      'baz' => \Bot\Commands\Baz::class,
    ],
  ],
]
```

To implement it to your bot:

```php
[
  ...,
  'bots' => [
    'foo' => [
      'token' => 'YOUR-BOT-TOKEN',
      'commands' => [
        'hamGroup',
      ],
    ],

    ...
  ],
]
```

4. Using combination of 1, 2 and 3 all together in one group.

### command_repository {#command_repository}

Command Repository lets you register commands that can be shared between one or more bots across the project.

This will help you prevent from having to register the same set of commands for each bot repeatedly and make it easier to maintain them.

Command Repository is not active by default. It would be best to use the key name to register them individually in a group of commands or bot commands.

Please think of this as central storage, to register, reuse, and maintain them across all bots.

```php
[
  ...,
  'command_repository' => [
    'foo' => \Bot\Commands\Foo::class,
    'bar' => \Bot\Commands\Bar::class,
    'baz' => \Bot\Commands\Baz::class,
    // ...
  ],
]

```
