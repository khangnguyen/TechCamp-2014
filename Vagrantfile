# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant::Config.run do |config|

    config.vm.box = 'precise32'
    config.vm.box_url = 'http://files.vagrantup.com/precise32.box'

    csync_port = 9252

    config.vm.forward_port 80, 9250
    config.vm.forward_port 22, 9251
    config.vm.forward_port 8888, csync_port

    #config.vm.boot_mode = :gui

    # apt wants the partial folder to be there
    apt_cache = './.cache/apt'
    FileUtils.mkpath "#{apt_cache}/partial"

    chef_cache = '/var/chef/cache'

    shared_folders = {
        apt_cache => '/var/cache/apt/archives',
        './.cache/chef' => chef_cache,
    }

    shared_folders.each do |source, destination|
        FileUtils.mkpath source
        folder_id = destination.gsub('/', '_')
        config.vm.share_folder folder_id, destination, source
        config.vm.customize ['setextradata', :id, "VBoxInternal2/SharedFoldersEnableSymlinksCreate/#{folder_id}", '1']
    end

    config.vm.customize ['setextradata', :id, 'VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root', '1']


    config.vm.provision :chef_solo do |chef|

        chef.provisioning_path = chef_cache

        chef.cookbooks_path = [
            'chef/chef-cookbooks',
            'chef/site-cookbooks',
        ]

        chef.roles_path = 'chef/chef-repo/roles'

        chef.json = {
            :skeleton => {
                :csync_enable => true,
                :csync_port => csync_port,
                :server_names => ['skeleton.cogini.com'],
                :log_dir => '/vagrant/logs',
                :site_dir => '/vagrant',
                :admin_email => 'support@vagrant.local',
                :db => {
                    :password => 'vagrant',
                },
                :app_user => 'vagrant',
            }
        }

        chef.add_role 'vagrant_attributes'
        chef.add_recipe 'vagrant'

        #chef.data_bags_path = '../my-recipes/data_bags'
    end
end
