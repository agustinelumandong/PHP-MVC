# PHP-MVC

A simple and lightweight MVC (Model-View-Controller) framework built with PHP.

## Requirements

- PHP 7.4 or higher
- Apache Server
- MySQL Database
- XAMPP/WAMP/MAMP (recommended)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/php-mvc.git
```
2. Configure your web server (Apache) to point to the project directory.

3. Import the database schema (if provided) into your MySQL server.

4. Configure the database connection in config/config.php .

Project Structure

php-mvc/
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
├── config/
├── public/
│   ├── css/
│   ├── js/
│   └── index.php
└── README.md

## Features
- MVC Architecture
- Clean URL Routing
- Database Abstraction Layer
- Simple Template Engine
- Error Handling

## Usage
1. Create new controllers in app/controllers/
2. Create new models in app/models/
3. Create new views in app/views/
4. Access your application through: http://localhost/php-mvc/

## Contributing
1. Fork the repository
2. Create your feature branch ( git checkout -b feature/amazing-feature )
3. Commit your changes ( git commit -m 'Add some amazing feature' )
4. Push to the branch ( git push origin feature/amazing-feature )
5. Open a Pull Request

## License
This project is licensed under the MIT License - see the LICENSE file for details.

