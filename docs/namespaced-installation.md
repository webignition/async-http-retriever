# Namespaced installation

A namespaced installation is one where the container names are unique to the installation. This is necessary
if you intend to run multiple live instances on the same host.

If you wish to upgrade without impacting the availability for applications that use the service, you should
opt for a namespaced installation.

If you ever intend to run multiple live instances on the same host (which requires non-conflicting container IDs and
non-conflicting service ports)

## Installation and configuration

Please refer to the [the installation guide](/docs/simple-installation.md) and the [the configuration guide](/docs/configuration.md)
but don't follow them. You just need to be aware of how to install and configure.

## Creating an isolated, namespaced installation

A namespaced installation has container names that are unique to the installation. Add to this service unique
service ports and you have an installation that will not be interfered by, or interfere with, any other
installations on the same host.

For example purposes, we will give our installation a name of `instance-x`. Additional installations might then
be called `instance-x`, `instance-z` and so on.

```bash
# GET CODE

# Start at the current user's home directory
# (not required, just a starting point for this example)
cd ~

# Create a directory for the instance, change to that directory and retrieve the code
mkdir -p /var/www/async-http-retriever-x
cd /var/www/async-http-retriever-x
git clone git@github.com:webignition/async-http-retriever.git .

# Create a directory for the MySQL data files for this instance
mkdir -p /var/docker-mysql/async-http-retriever-x

# Change to the docker directory as that is where all the fun happens
cd docker

# CONFIGURE

# Create the configuration
cp .env.dist .env

# We need to set the MySQL data path on the host
sed -i 's|MYSQL_DATA_PATH_ON_HOST|/var/docker-mysql/async-http-retriever-x|g' .env

# Set a non-default rabbit-mq management interface port
sed -i 's|15672|25672|g' .env

# Set a non-default application port
sed -i 's|8001|8002|g' .env

# INSTALL

ID=instance-x docker-compose -p instance-x up -d --build
ID=instance-x docker-compose -p instance-x exec -T app-web composer install
ID=instance-x docker-compose -p instance-x exec -T app-web ./bin/console doctrine:migrations:migrate --no-interaction
ID=instance-x docker-compose -p instance-x down
ID=instance-x docker-compose -p instance-x up -d
```

## Creating additional isolated, namespaced installations

Repeat the above changing:

- `instance-x` to `instance-y` (or to whatever you wish to name your installation)
- the rabbit-mq management interface port
- the application port

## Zero-downtime upgrades using two installations

Please refer to the [multiple live instances guide](/docs/multiple-live-instances.md) for an example
of how to use two live instances to offer a zero-downtime upgrade.