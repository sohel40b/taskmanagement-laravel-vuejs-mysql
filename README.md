<a name="readme-top"></a>

<!-- GETTING STARTED -->
## Getting Started

Task Management System App build by Laravel and VueJS 3

### Version

- PHP > 8.1
- Laravel > 10.42.0
- VueJS > 3
- MySQL > 5.7.39

### Installation

This is an example of how you may give instructions on setting up your project locally. To get a local copy up and running follow these simple example steps.

1. Clone the repo
   ```sh
   git clone https://github.com/sohel40b/taskmanagement-laravel-vuejs-mysql.git
   ```
2. Open Project app and run command in terminal
   ```sh
   cp .env.example .env
   ```
   Change your .env file with your configuration
   ```sh
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=root
   DB_PASSWORD=root

   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=******
   MAIL_PASSWORD=******
   ```
   ```sh
   composer install
   ```
   ```sh
   php artisan key:generate 
   ```
   ```sh
   php artisan migrate
   ```
3. Finally install and run server in terminal
   ```sh
   npm install
   ```
   ```sh
   npm run dev
   ```
4. Run server command in others terminal
   ```sh
   php artisan serve
   ```
5. Run Job Queue another terminal
   ```sh
   php artisan queue:work
   ```
<p align="right">(<a href="#readme-top">back to top</a>)</p>
