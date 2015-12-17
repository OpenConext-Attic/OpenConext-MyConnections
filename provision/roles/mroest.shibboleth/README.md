# Ansible Role: Apache Shibboleth

An Ansible Role that installs Apache Shibboleth on Centos 7 servers.

## Requirements

Java must be available on the server. You can easily install Java using the `geerlingguy.java` role.


## Example Playbook

    - hosts: servers
      roles:
        - { role: geerlingguy.java }
        - { role: mroest.shibboleth }

