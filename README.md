# project Alzikrayat 

A photo-sharing web application built for the Advanced Web Technologies course (7th semester) at Sudan University of Science and Technology, College of Computer Science and Information Technology.

Users can register, log in, upload photos with a title and description, browse a shared gallery, and comment on each other's photos.

## Why no framework?

The entire backend is built from scratch in raw PHP — no Laravel, no Symfony, no ORM. That was a hard requirement of the project, and the point was to actually understand how routing, database connections, and sessions work under the hood before relying on a framework to do it for me.

## Architecture

Built with MVC on top of a 3-tier structure:

- Views — HTML pages styled with Bootstrap
- Controllers — handle incoming requests and decide what happens
- Models — talk to the database directly

On top of that sits a hand-written Router that matches incoming URLs like /photo/25 using regular expressions, extracts the parameter, and dispatches it to the right controller action.

## Features

- Registration and login with hashed passwords (Bcrypt)
- A cookie that remembers the last login time from the same browser (persists for 7 days)
- Photo upload with title and description
- Gallery with switchable display styles (3-column, 4-column, list)
- Photo deletion — restricted to the owner only
- Comments on photos
- Three validation layers: HTML5, JavaScript, and server-side
- Protection against SQL injection (parameterized queries) and XSS (output escaped with htmlspecialchars)

## Project structure
'''
project/
├── config/          # Database connection
├── core/            # Base Router, Model, Controller
├── controllers/     # Auth, Photo, Comment
├── models/          # User, Photo, Comment
├── views/           # Pages
├── routes/          # Route registration
└── public/          # Entry point + uploaded images




'''
 




## Running it locally

1. Place the project folder inside XAMPP's htdocs
2. Start Apache and MySQL from the XAMPP control panel
3. Create a database named alzikrayat in phpMyAdmin
4. Run the three table creation scripts (users, photos, comments) — full schema is in the architecture report
5. Open http://localhost/project/public/

## Stack

Raw PHP (PDO for the database layer), MySQL, Bootstrap, and plain JavaScript for client-side validation.

---
Individual project — Raheeg | Advanced Web Technologies | Sudan University of Science and Technology

Raheeg abd alazeim mohamad 
Information Tecnologey
