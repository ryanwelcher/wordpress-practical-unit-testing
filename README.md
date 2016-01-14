#WordPress Unit Testing with PHPUnit and WP_MOCK #



##Installation##
[Install PHPUnit](https://phpunit.de/manual/current/en/installation.html) globally and make sure it's in your path

Clone this repo locally: `git clone https://github.com/ryanwelcher/unit-test-wp-mock.git`

Navigation to the directory: `cd unit-test-wp-mock`

Run `composer install` to install phpunit and WP_Mock.

Once installed, run `phpunit` to run the test suite.


##Vagrant##

If you're using VVV or another Vagrant based virtual machine, you can add the following line to your CustomFile or VagrantFile
to load the plugin into WordPress - just update the paths as needed.

`config.vm.synced_folder "~/repositories/unit-test-examples", "/srv/www/wordpress-develop/src/wp-content/plugins/unit-test-example", owner: 'www-data', group: 'www-data', mount_options: ["dmode=775", "fmode=664"]`

This step is not required as the plugin does nothing of value.

##References##

[Composer](http://getcomposer.org)

[PHPUnit](https://phpunit.de/)

[WP_MOCK](https://github.com/10up/wp_mock)