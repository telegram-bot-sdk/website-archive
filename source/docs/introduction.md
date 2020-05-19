---
title: Introduction
description: 
extends: _layouts.documentation
section: content
---

# Introduction {#introduction}

Telegram Bot SDK is a framework that can be used to build powerful Telegram Bot's. You can use it as a stand-alone library but even more powerful is to use it with Laravel.

# What is new {#whatisnew}

Now events are capable of two-way communication in our SDK. So events can not only listen but can also modify the data on-fly.
This would open door to create different kinds of plugins that are plug and play and that can manipulate data for you.

Some examples:
- Logger Plugin for the SDK that log all inbound updates.
- Emojify Plugin
- Analytics Plugin
- Registration / Auth System.
- Data Processors for different update types.
... Endless possibilities.

We will have skeleton as well as some of our official plugins which can be used as a reference point for developers, this isn't a priority at this time but it's in our pipeline.

Summary of features: PHP 7.4, Laravel 6 and 7 Support (with its own package with some nice handy artisan commands, webhook setup/controller that just works out of the box), Events, Rewritten Objects and many parts of the SDK. Better Keyboard system, Decoupled API/Non-API methods into separate classes, PSR-12 Code Styling, New Github Issue templates, Simplified Commands system (it's a whole new system that's super easy and yet another stuff that just works, no longer needs param signatures) and so on.