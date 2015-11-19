# OpenConext My Connections

## System requirements

* Virtualbox >=5.0
* Vagrant >=1.7.4
* Ansible >=1.9.4

# Vagrant setup

Initialize the vagrant box by running:

    vagrant up

# Ansible

## Updating your roles
In order to update the ansible galaxy roles there is `roles.yml` file. To update run:

    ansible-galaxy install -r roles.yml --force

# Mailhog
See: https://github.com/mailhog/MailHog