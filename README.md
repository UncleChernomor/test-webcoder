# test-webcoder

## You have to execute create_db.php script

php create_db.php

## The project uses an embedded PHP server. Entry point start.php

## For example:

php -S localhost:3000 start.php

## Current task

There is a page with a form to "add a new employee".
Form fields:

email (must be unique)

user name

user address

phone number

comments

department (select from another entity)

There is a page for departments. It displays a list of existing departments with the ability to add a new one and delete existing ones. It's very simple—just one field: "name" (must be unique).

There is a page "all users" with a list of all users and their departments. By clicking on a specific user, you are taken to their detailed profile page.

You need to create routes using human-readable URLs (pretty URLs / clean URLs).
The links for all these pages should not look like index.php or user.php?id=1, but for example:
app.loc/users, app.loc/add-user, app.loc/user/1

Requirements:

It must use the MVC pattern

The database connection settings must be in a separate file

Use proper routes with pretty URLs

Do not use any CMS

Do not use any frameworks

The entire development process should be visible in git (not just a single final commit like "code", but step by step)

For the frontend, you may use Bootstrap

## What I'd like to add...
1. CSRF
2. Improve validation
3. Add Edit and Update