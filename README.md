## Installation

Requirements
**Before installing Project Name, make sure that your system meets the following requirements:**

PHP >= 7.3.0
Composer
Web server (e.g. Apache, Nginx)
MySQL or other supported database server

## Steps

**Follow the steps below to install Project Name:**

**Clone the repository:**

git clone [https://github.com/username/project-name.git]
Change into the project directory:

cd project-name   (change directory) 
**Install project dependencies:**
composer install

**Create a new .env file by copying the .env.example file:**
cp .env.example .env
**Generate an application key:**
vbnet
php artisan key:generate
Update the .env file with your database credentials.

**Migrate the database:**

php artisan migrate
Seed the database:

php artisan db:seed
Start the development server:

php artisan serve
Open a web browser and go to [http://localhost:8000] to see the Project Name application.

### Running the App in a Docker Container

To run the app in a Docker container, follow these steps:

### Install Docker on your machine.

Open the terminal and navigate to the project directory.

**Run the following command to create the build:**
docker-compose build

**Once built is done, run the following command :**
docker-compose up -d
This will start the container and you can access the app at [http://localhost:3000].
