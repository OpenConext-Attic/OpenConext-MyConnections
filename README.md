# OpenConext My Connections

Documentation on this project is found at: https://wiki.surfnet.nl/display/P3GFeI2015/ORCID+voor+SURFconext
In short this will allow users to enrich their Open-Conext userprofile with a service like ORCID http://orcid.org
and let SP's use this information.

## System requirements

* Virtualbox >=5.0
* Vagrant >=1.7.4
* Ansible >=1.9.4
* Composer

Vagrant plugins:

    vagrant-hostsupdater (1.0.1)
    vagrant-share (1.1.5, system)
    vagrant-vbguest (0.11.0)

# Setup project

Clone this git repository

Initialize the vagrant box by running:

    vagrant up

This will provision two boxes. One for the App itself and one for a dummy/test IDP.
The IDP is required to mock the open-conext authentication (which is required in order to connect with services like ORCID).
The IDP is a basic SimpleSAMLphp install that returns the required attributes after login.

Then install all dependencies by running:

    composer install


Create database schema by running

    ./console doctrine:database:create (only first time)
    AND/OR
    ./console doctrine:schema:update --force


# Provisioning

## Provision Centos7 Server
    cd provision/
    ansible-playbook -i inventory -s provision.yml (mind the -s param)

## Deploy App and/or a new release.
    cd provision/
    ansible-playbook -i inventory deploy.yml

It will ask you for a release version. Simply enter a branch/tag name. (ie. master or release-0.4).

## Updating your Ansible roles
In order to update the ansible galaxy roles there is `requirements.yml` file. To update run:

    ansible-galaxy install -r requirements.yml --force

# Accessing the box

## App
 - http://dev.myconnections.org/ (PROD)
 - http://dev.myconnections.org/app_dev.php/ (DEV)
 
## SP Metadata
 - http://dev.myconnections.org/authentication/metadata

## IDP (only for dev/testing)
You can find the IDP setup in the folder `idp-test/`

 - http://dev.idp.org

## My Connections REST API
See the file [api_doc.md](api_doc.md)

# Adding a service (Like ORCID) to the App.
In order to add a service like ORCID to the app you have to the following.

## Add controller for linking
See for example the ORCID controller. It enables a number of endpoints to interface with the ORCID.
You will have to change this based on the needs of your service.

## Update App routes
Add the controller to the `Resources/config/routing.yml` and enable the routes.

## Configure the service
Add a service to `Resources/config/services.yml` like `app.service.orcid`.
You can use the servicefactory to create the service.

## Add service to the repository
Add your service to the repository by adding a addConnection() call to the repository service `app.service.repository`

# Mailhog
In order to view whats in the mailqueue go to: http://dev.myconnections.org:8025
See: https://github.com/mailhog/MailHog for additional documentation about Mailhog.

PS. We dont send email so there shouldn't be any mail there.. :)

# Setup with public available OpenConext IDP

In order to set this up with a public available Open-Conext IDP change the following params in `app/config/parameter.yml`

    saml_remote_idp_entity_id: 'http://dev.idp.org/saml2/idp/metadata.php'
    saml_remote_idp_sso_url: 'http://dev.idp.org/saml2/idp/SSOService.php'
    saml_remote_idp_certificate: MIIDzTCCAr....

# Running the tests
In order to run the test you have to logon the vagrant box first (due to dbaccess).

    vagrant ssh vagrant-app
    cd /vagrant/app
    ../bin/phpunit

