Slender CMS
===

Setup
=====

From your terminal
```
git clone git@github.com:dwsla/slender-cms.git
cd slender-cms
```

* If needed, download & install virtual box 4.2.x: http://www.virtualbox.org/wiki/Downloads
* If needed, Download & install vagrant latest: http://downloads.vagrantup.com/

From the terminal (inside slender-cms dir):
* vagrant box add centos-6.3-i386 https://opscode-vm.s3.amazonaws.com/vagrant/boxes/opscode-centos-6.3-i386.box #Only if you havent used this box before.
* vagrant up
* vagrant ssh (if on windows: http://vagrantup.com/v1/docs/getting-started/ssh.html)
* Verify that the storage/views directory is writable.


Once you ssh in, cd to /vagrant and run:
```
php composer.phar --verbose install
```

This should give you a working TV4 CMS on http://localhost:4002 from the host, and http://localhost:80 from inside the VM.
