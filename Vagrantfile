# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant::Config.run do |config|
  config.vm.box = "centos-6.3-i386"
  config.vm.forward_port 80, 4002
  config.vm.forward_port 27017, 27018

  config.vm.provision :chef_solo do |chef|
	chef.cookbooks_path = "vagrant/cookbooks"
	chef.add_recipe("slender-cms::nameservers")
	chef.add_recipe("slender-cms::hostname")
	chef.add_recipe("slender-cms::bash")
	chef.add_recipe("slender-cms::epel")
	chef.add_recipe("slender-cms::scm")
	chef.add_recipe("slender-cms::mongo")
	chef.add_recipe("slender-cms::php")
	chef.add_recipe("slender-cms::apache")
  end

end
