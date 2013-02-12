bash "set_hostname" do
  user "root"
  code <<-EOH
    hostname slender-cms.local
  EOH
end
