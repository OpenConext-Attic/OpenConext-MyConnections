# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config_values = {
    cpus: 2,
    memory: 1024,
    nfs: true
  }

  # Overwrites config_values
  if File.exists? 'Vagrantfile.local'
    eval File.read 'Vagrantfile.local'
  end

  # Default vagrant box (get one from remote location)
  config.vm.box = "geerlingguy/centos7"

  config.vm.define "vagrant-app", primary: true do |app|
      app.vm.hostname = "dev.myconnections.org"
      app.vm.network "private_network", ip: "33.34.35.36"

      # @see http://www.virtualbox.org/manual/ch08.html#idp58775840
      app.vm.provider "virtualbox" do |v|
        v.customize [
          "modifyvm", :id,
          "--paravirtprovider", "kvm",
          "--cpus", config_values[:cpus],
          "--memory", config_values[:memory],
          "--name", "myconnections-app"
        ]
      end
  end

  config.vm.define "vagrant-idp" do |idp|
      idp.vm.hostname = "dev.idp.org"
      idp.vm.network "private_network", ip: "33.34.35.37"

      # @see http://www.virtualbox.org/manual/ch08.html#idp58775840
      idp.vm.provider "virtualbox" do |v|
        v.customize [
          "modifyvm", :id,
          "--paravirtprovider", "kvm",
          "--cpus", config_values[:cpus],
          "--memory", config_values[:memory],
          "--name", "myconnections-idp"
        ]
      end
  end

  config.vm.synced_folder "./", "/vagrant", id: "vagrant-root", :nfs => config_values[:nfs]
  config.vm.provision :ansible do |ansible|
    ansible.inventory_path = "provision/vagrant"
    ansible.playbook = "provision/provision.yml"
    ansible.sudo = true
  end
end
