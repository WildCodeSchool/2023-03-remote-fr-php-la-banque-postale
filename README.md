# Project 3 - Starter Kit - Symfony

<!-- TOC -->
* [Project 3 - Starter Kit - Symfony](#project-3---starter-kit---symfony)
  * [Presentation](#presentation)
  * [Getting Started for Students](#getting-started-for-students)
    * [Prerequisites](#prerequisites)
    * [Install](#install)
    * [Working](#working)
    * [Testing](#testing)
    * [Windows Users](#windows-users)
    * [Run locally with Docker](#run-locally-with-docker)
  * [Deployment](#deployment)
  * [Built With](#built-with)
  * [Contributing](#contributing)
  * [Versioning](#versioning)
  * [Authors](#authors)
  * [License](#license)
* [Presentation de la LIGNE BLEUE](#presentation-de-la-ligne-bleue)
  * [Team](#team)
  * [Using this project](#using-this-project)
  * [Login Credentials](#login-credentials-)
  * [Bundles](#bundles)
  * [Acknowledgments](#acknowledgments)
<!-- TOC -->

## Presentation

This starter kit is here to easily start a repository for Wild Code School students.

It's symfony website-skeleton project with some additional library (webpack, fixtures) and tools to validate code standards.

* GrumPHP, as pre-commit hook, will run 2 tools when `git commit` is run :

    * PHP_CodeSniffer to check PSR12
    * PHPStan focuses on finding errors in your code (without actually running it)
    * PHPmd will check if you follow PHP best practices

  If tests fail, the commit is canceled and a warning message is displayed to developper.

* Github Action as Continuous Integration will be run when a branch with active pull request is updated on github. It will run :

    * Tasks to check if vendor, .idea, env.local are not versionned,
    * PHP_CodeSniffer, PHPStan and PHPmd with same configuration as GrumPHP.

## Getting Started for Students

### Prerequisites

1. Check composer is installed
2. Check yarn & node are installed

### Install

1. Clone this project
2. Run `composer install`
3. Run `yarn install`
4. Run `yarn encore dev` to build assets

### Working

1. Run `symfony server:start` to launch your local php web server
2. Run `yarn run dev --watch` to launch your local server for assets (or `yarn dev-server` do the same with Hot Module Reload activated)

### Testing

1. Run `php ./vendor/bin/phpcs` to launch PHP code sniffer
2. Run `php ./vendor/bin/phpstan analyse src --level max` to launch PHPStan
3. Run `php ./vendor/bin/phpmd src text phpmd.xml` to launch PHP Mess Detector
4. Run `./node_modules/.bin/eslint assets/js` to launch ESLint JS linter

### Windows Users

If you develop on Windows, you should edit you git configuration to change your end of line rules with this command:

`git config --global core.autocrlf true`

The `.editorconfig` file in root directory do this for you. You probably need `EditorConfig` extension if your IDE is VSCode.

### Run locally with Docker

1. Fill DATABASE_URL variable in .env.local file with
`DATABASE_URL="mysql://root:password@database:3306/<choose_a_db_name>"`
2. Install Docker Desktop an run the command:
```bash
docker-compose up -d
```
3. Wait a moment and visit http://localhost:8000


## Deployment

Some files are used to manage automatic deployments (using tools as Caprover, Docker and Github Action). Please do not modify them.

* [Dockerfile](/Dockerfile) Web app configuration for Docker container
* [docker-entry.sh](/docker-entry.sh) shell instruction to execute when docker image is built
* [nginx.conf](/ginx.conf) Nginx server configuration
* [php.ini](/php.ini) Php configuration


## Built With

* [Symfony](https://github.com/symfony/symfony)
* [GrumPHP](https://github.com/phpro/grumphp)
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [PHPStan](https://github.com/phpstan/phpstan)
* [PHPMD](http://phpmd.org)
* [ESLint](https://eslint.org/)


## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning


## Authors

Wild Code School trainers team

## License

MIT License

Copyright (c) 2019 aurelien@wildcodeschool.fr

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

<img src="assets/images/img_bg.png">

#  Presentation de la LIGNE BLEUE

The "Ligne Bleue" project by La Banque Postale is an initiative aimed at promoting digital inclusion by helping individuals in digital distress acquire essential digital skills. It is an educational platform that offers tutorials and resources to enable users to develop their knowledge and skills in the digital domain.

The key features of "Ligne Bleue" include:

Tutorials: Users have access to a wide range of tutorials covering various topics related to digital technology, such as internet navigation, social media usage, email management, online security, and more. These tutorials are designed in a pedagogical manner to facilitate user learning.

Quizzes: To assess their level of skills, users can participate in interactive quizzes. These quizzes allow them to test their knowledge and track their progress. Quiz results are recorded and can be viewed on the user's profile.

User Profile: Each user has a personal profile where they can track their progress, view their quiz results, and see the tutorials they have completed. The profile provides an overview of the user's acquired skills and encourages them to continue their learning journey.

Adding Friends: Users have the option to add other application users as friends. Adding friends promotes the social aspect of the platform and encourages users to support each other in their learning journey.

In summary, the "Ligne Bleue" project is an educational platform focused on digital inclusion. It offers tutorials, quizzes, and a user profile to help individuals in digital distress develop their digital skills, assess their level, and track their progress. Additionally, social features such as adding friends foster interaction among users and create a supportive learning community.

## Team

* Alexis MICHELAS
* Titouan LAHELY
* Nina SCHADEL
* Baptiste CHASSET
* Joss LENOIR

## Using this project
1. Change your env.local with your database information.
2. Run the command : 
``` bash
 bash script.sh 
```
for the creation of the database and the fixture loader.
3. Dont forget to implement your mailer for the e-card page.
4. Enjoy your visit.

## Login Credentials 
For the admin : 
* Email : admin@test.com
* Password : test1

For the user :
* Email : user@test.com
* Password : test1


## Bundles
For this project we used many bundles : 

* ### KNP Paginator Bundle : 
We have used KNP for the pagination of the galery.
* ### FOS CKEditor Bundle :
To allow users to customize the formatting of their message when they send their e-cards.
* ### Doctrine Fixture Bundle :
Symfony extension for automated loading of test data into the database.
* ### Exercise HTMLPurifier Bundle :
Symfony bundle for sanitizing and filtering HTML input to prevent XSS attacks and maintain secure content.
* ### Symfony UX / Stimulus :
* #### StimulusBundle:
Symfony bundle that integrates the Stimulus JavaScript framework, providing a lightweight and modular approach to enhance interactivity and behavior in web applications.
* #### TwigComponentBundle:
Symfony bundle that enhances the Twig templating engine by providing a set of reusable and modular components, allowing for more efficient and organized development of user interface elements in web applications.
* #### Live Component : 
For the bookmark component.
* ### Progressbar.js : 
A simple code example of creating a Line shaped progress bar and animating it from 0% to 100%.
https://kimmobrunfeldt.github.io/progressbar.js/

## Acknowledgments

We would like to thank : 
* La Banque Postale for this wonderful opportunity,
* The Wild Code School for having helping us to learning code.
* All the people in Stack Overflow and others forum for their help for some of our features
* And most of all, we would like to thank our teacher, grand-master, dojo-sensei, Jean-François for his help, his
patience, all his code-reviews and all the things we've learned from him.
