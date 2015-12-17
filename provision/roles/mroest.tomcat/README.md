# Ansible Role: Apache Tomcat

An Ansible Role that installs Apache Tomcat on Centos 7 servers.

## Requirements

Java must be available on the server. You can easily install Java using the `geerlingguy.java` role.


## Example Playbook

    - hosts: servers
      roles:
        - { role: geerlingguy.java }
        - { role: mroest.tomcat }

