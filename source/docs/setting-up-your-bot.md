---
title: Setting Up Your Bot
description:
extends: _layouts.documentation
section: content
---

# Setting Up Your Bot

This section will explain how to setup all of your bots from `config/telegram.php` file.

Open `config/telegram.php`:

## <a name="use"></a>[`use`](#use)

Default bot name if there's no bot name specified on `telegram()`.

```
$me = telegram()->getMe();   // Will be using default bot from "use" key value
```

## <a name="bots"></a>[`bots`](#bots)

| Type  | Value                             |
| ----- | --------------------------------- |
| Array | `[ array of bot configurations ]` |

`bots` key contains all of your bot configuration.

As for version `v4.0` or newer, you can `listen` to events sent to your bot and set fully customizable `Event Listener` for each request sent to your bot. Learn more about [Handling Events]().

You can also assign `commands` or `commands_group` to work with your bot seamlessly. Learn more about [Commands setup]().

Here's an example of bot configuration format:

```
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

|         Key         |               Usage                |  Type  |
| :-----------------: | :--------------------------------: | :----: |
|      username       |     Your Telegram Bot Username     | String |
|        token        |      Your Telegram Bot Token       | String |
| commands (Optional) | List of [Command](#commands) class | Array  |
|  listen (Optional)  |  List of [Event Listener]() class  | Array  |

You can register as many bot configuration as you want, just make sure your bot name is unique for each bot config.

Here's an example of multi-bot usage:

```
$myFirstBot = telegram()->bot('myFirstBot')->getMe();
print_r($myFirstBot);

$mySecondBot = telegram()->bot('mySecondBot')->getMe();
print_r($mySecondBot);
```

## <a name="webhook"></a>[`webhook`](#webhook) (Optional)

Webhook domain configuration for CLI webhook setup helper.

Go to [Webhooks page]() to learn how to setup webhook for your bot.

|  Key   |               Usage               |  Type  |
| :----: | :-------------------------------: | :----: |
| domain | Domain for inbound webhook update | String |

## <a name="http"></a>[`http`](#http) (Optional)

HTTP client configuration for the SDK.
| Key | Usage | Type |
| :----: | :-------------------------------: | :----: |
| config | To set HTTP Client config (Ex: proxy). | String |
| async | When set to True, All the requests would be made non-blocking (Async). | String |
| async | To set the Base API URL. | String |
| client | To set HTTP Client. Should be an instance of @see `\Telegram\Bot\Contracts\HttpClientInterface::class` | String |

## <a name="commands"></a>[`commands`](#commands) (Optional)

This SDK has build in command handler system. You can register commands for all of your bots at once. This array will be applied as **global command** across all of your bots and will be always active.

By default, the SDK shipped with `help` command which when a user sends `/help` your bot will respond with a list of available commands and it's description.

The command class should extend the `\Telegram\Bot\Commands\Command` class.

|      Key       |                        Value                         |
| :------------: | :--------------------------------------------------: |
| `command_name` | Class that extends `\Telegram\Bot\Commands\Command`. |

Go to [Commands]() page see advance usage and examples.

## <a name="command_groups"></a>[`command_groups`](#command_groups) (Optional)

You can organize a set of commands into groups which can later be re-used across all of your bots.

You can create 4 types of `command_groups`:

1. Using full path to command classes.

```
"foo" => \Bot\Commands\Foo::class
```

2. Group using command respository name (see [command_repository](#command_repository) section below).

```
"fooGroup" => "foo"
```

3. Using other `command_groups` name
   For example, take a look at `all` group:

```
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

## <a name="command_repository"></a>[`command_repository`](#command_repository) (Optional)

Command Repository lets you register commands that can be shared between one or more bots across the project.

This will help you prevent from having to register same set of commands, for each bot over and over again and make it easier to maintain them.

Command Repository are not active by default, you need to use the key name to register them, individually in a group of commands or in bot commands.

Think of this as a central storage, to register, reuse and maintain them across all bots.

```
"command_repository" => [
  "foo" => \Bot\Commands\Foo::class,
  "bar" => \Bot\Commands\Bar::class,
],
```
