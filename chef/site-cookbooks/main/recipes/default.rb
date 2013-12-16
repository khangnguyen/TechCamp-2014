j#
# Cookbook Name:: main
# Recipe:: default
#
# Copyright 2012, Cogini
#
# All rights reserved - Do Not Redistribute
#

include_recipe 'apt'
include_recipe 'htpasswd'
include_recipe 'php::module_pgsql'
include_recipe 'php::module_apc'
include_recipe 'php::fpm'
include_recipe 'postgresql::client'
include_recipe 'git'
include_recipe 'python'


yii_version = node[:techcamp][:yii_version]
app_user = node[:techcamp][:app_user]
db = node[:techcamp][:db]
site_dir = node[:techcamp][:site_dir]


yii_framework yii_version do
    symlink "#{site_dir}/../yii"
end


if db[:host] == 'localhost'

    include_recipe 'postgresql::server'
    db_user = db[:user]

    postgresql_user db_user do
        password db[:password]
    end

    postgresql_database db[:database] do
        owner db_user
    end
end


user app_user do
    home "/home/#{app_user}"
    shell '/bin/bash'
    supports :manage_home => true
    action :create
end


template "#{site_dir}/protected/config/local.php" do
    source 'yii-local.php.erb'
    mode '644'
end

template "#{site_dir}/protected/config/db.json" do
    source 'yii-db.json.erb'
    mode '644'
end

template "#{site_dir}/protected/scripts/set_env.sh" do
    source 'set_env.sh.erb'
    mode '644'
end


%w{ protected/runtime assets images/uploads }.each do |component|

    the_dir = "#{site_dir}/#{component}"

    bash 'setup permissions' do
        code <<-EOH
            mkdir -p #{the_dir}
            chown -R www-data:#{app_user} #{the_dir}
            chmod -R ug+rwX #{the_dir}
            find #{the_dir} -type d | xargs chmod g+x
        EOH
    end
end


# Schemup
%w{libpq-dev}.each do |pkg|
    package pkg do
        action :install
    end
end

python_env = node[:techcamp][:python][:virtualenv]
build_dir = node[:techcamp][:python][:build_dir]


[build_dir, python_env].each do |dir|
    directory dir do
        action :create
        recursive true
    end
end


python_virtualenv python_env do
    action :create
end

# Other dependencies
bash 'install python dependencies' do
    code <<-EOH
        . #{python_env}/bin/activate
        pip install -r #{site_dir}/protected/schema/requirements.txt
    EOH
end

bash 'run schemup' do
    cwd "#{site_dir}/protected/schema"
    code <<-EOH
        . #{python_env}/bin/activate
        python update.py commit
    EOH
end


template '/etc/logrotate.d/khangnguyen.me' do
    mode '644'
    source 'logrotate.erb'
end


if node[:techcamp][:htpasswd]
    node[:techcamp][:htpasswd].each do |username, passwd|
        htpasswd "#{site_dir}/../.htpasswd" do
            user username
            password passwd
        end
    end
end
