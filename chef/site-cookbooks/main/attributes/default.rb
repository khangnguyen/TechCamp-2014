set[:voting][:yii_version] = '1.1.13'

default[:voting][:app_user] = 'voting'
default[:voting][:csync_enable] = false
default[:voting][:csync_port] = 0
default[:voting][:db][:database] = 'techcamp'
default[:voting][:db][:host] = 'localhost'
default[:voting][:db][:user] = 'techcamp'

default[:voting][:python][:virtualenv] = '/home/ubuntu/python-env'
default[:voting][:python][:build_dir] = '/home/ubuntu/build'
set[:voting][:python][:schemup][:version] = '5f5d35f5c7e9708e62ca43aa4743610e2cb696ae'
