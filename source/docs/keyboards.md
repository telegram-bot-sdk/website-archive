---
title: FrKeyboards
description: 
extends: _layouts.documentation
section: content
---

# Keyboards {#keyboards}


```php
ReplyKeyboardMarkup::make()
    ->row(
        KeyboardButton::make()->text('Button One'),
        KeyboardButton::make()->text('Button Two')->requestContact(true),
        KeyboardButton::make()->text('Button Three')->requestLocation(true),
    )
    ->row(
        'Button Four', //You can use simple text for a button if you wish.
        KeyboardButton::make()->text('Button Five')->requestPoll(KeyboardButtonPollType::setAsQuiz()),
        KeyboardButton::make()->text('Button Six'),
    )
    ->oneTimeKeyboard(true)
    ->resizeKeyboard(false)
    ->selective(true);
```