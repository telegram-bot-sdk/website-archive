---
title: Setting Up Your Bot
description:
extends: _layouts.documentation
section: content
---

# Setting Up Your Bot

This section will explain how to setup all of your bots.

Open `config/telegram.php`:

## use {$use}

Default bot name if there's no bot name specified while sending a request.

```php
$default = telegram()->getMe();   // Will be using default bot from "use" key value.

$foo = telegram()->bot('foo')->getMe();  // Will be using 'foo' bot.
```

## bots {$bots}

| Type  | Value                             |
| ----- | --------------------------------- |
| Array | `[ array of bot configurations ]` |

`bots` key contains all of your bot configuration.

As for version `v4.0` or newer, you can `listen` to events sent to your bot and set fully customizable `Event Listener` for each request sent to your bot.

You can also assign [`commands`](#commands) or [`command_groups`](#command_groups) to work with your bot seamlessly.

Here's an example of bot configuration format:

```php
...
'default' => [
  ...
],
'mySecondBot' => [
  'username'    => 'SecondBotUsername',
  'token'       => 'SecondBotToken',
  'commands'    => [],                  # (Optional)
  'listen'      => [],                  # (Optional)
],
...
```

|         Key         |                                                        Usage                                                         |  Type  |
| :-----------------: | :------------------------------------------------------------------------------------------------------------------: | :----: |
|      username       |                                              Your Telegram Bot Username                                              | String |
|        token        |                                               Your Telegram Bot Token                                                | String |
| commands (Optional) | List of [`commands`](#commands), [`command_groups`](#command_groups), or [`command_repository`](#command_repository) | Array  |
|  listen (Optional)  |                           List of [Event Listener](#) class                           | Array  |

You can register as many bot configuration as you want, just make sure your bot name is unique for each bot config.

Here's an example of multi-bot usage:

```php
$myFirstBot = telegram()->bot('myFirstBot')->getMe();
print_r($myFirstBot);

$mySecondBot = telegram()->bot('mySecondBot')->getMe();
print_r($mySecondBot);
```

## webhook {#webhook}

Webhook domain configuration for CLI webhook setup helper.

Go to [Webhooks section](#) to learn how to setup webhook for your bot.

|  Key   |               Usage               |  Type  |
| :----: | :-------------------------------: | :----: |
| domain | Domain for inbound webhook update | String |

## http {#webhook}

HTTP client configuration for the SDK.
| Key | Usage | Type |
| :----: | :-------------------------------: | :----: |
| config | To set HTTP Client config (Ex: proxy). | String |
| async | When set to True, All the requests would be made non-blocking (Async). | String |
| async | To set the Base API URL. | String |
| client | To set HTTP Client. Should be an instance of @see `\Telegram\Bot\Contracts\HttpClientInterface::class` | String |

## commands {#commands}

This SDK has build in command handler system. You can register commands for all of your bots at once. This array will be applied as **global command** across all of your bots and will be always active.

By default, the SDK shipped with `help` command which when a user sends `/help` your bot will respond with a list of available commands and it's description.

The command class should extend the `\Telegram\Bot\Commands\Command` class.

|      Key       |                        Value                         |
| :------------: | :--------------------------------------------------: |
| `command_name` | Class that extends `\Telegram\Bot\Commands\Command`. |

Go to [Commands System](/docs/command-system) page to see advanced usage and examples.

## command_groups {#command_groups}

You can organize a set of commands into groups which can later be re-used across all of your bots.

You can create 4 types of `command_groups`:

1. Using full path to command classes.

```php
"foo" => \Bot\Commands\Foo::class
```

2. Group using command respository name (see [`command_repository`](#command_repository) section below).

```php
"fooGroup" => "foo"
```

3. Using other `command_groups` name
   For example, take a look at `all` group:

```php
"command_groups" => [
    "foo" => [
        "foo" => \Bot\Commands\Foo::class,
        "bar" => \Bot\Commands\Bar::class,
    ],
    "all" => [
        "foo",
        "baz" => \Bot\Commands\Baz::class,
    ],
],
```

4. Using combination of 1, 2 and 3 all together in one group.

## command_repository {#command_repository}

Command Repository lets you register commands that can be shared between one or more bots across the project.

This will help you prevent from having to register same set of commands, for each bot over and over again and make it easier to maintain them.

Command Repository are not active by default, you need to use the key name to register them, individually in a group of commands or in bot commands.

Think of this as a central storage, to register, reuse and maintain them across all bots.

```php
"command_repository" => [
  "foo" => \Bot\Commands\Foo::class,
  "bar" => \Bot\Commands\Bar::class,
],
```
