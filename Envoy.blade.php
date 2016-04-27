@servers(['live' => 'root@live.issuemonitoring.ro', 'staging' => 'root@staging.issuemonitoring.ro'])

@setup
	$repo = "git@github.com:ElasticOrange/issue-monitoring.git";
	$release_dir = "/usr/share/nginx/issuemonitoring/releases";
	$app_dir = "/usr/share/nginx/issuemonitoring/current";
	$storage_dir = "/usr/share/nginx/issuemonitoring/";

	$now = new DateTime();
	$now_microtime = substr(microtime(), 2, 8);
	$timestamp = $now->format('Ymd-His') .'-'. $now_microtime;
	$release = "release_{$timestamp}";
@endsetup

@macro('deploy')
	test_connectivity
	fetch_repo
	setup_env
	setup_storage
	build_app
	update_permissions
	delete_old_releases
	update_symlinks
	restart_queue
@endmacro

@task('test_connectivity', ['on' => $on])
	echo "Updating server {{ $on }}";
@endtask

@task('fetch_repo', ['on' => $on, 'branch' => $branch])
	[ -d {{ $release_dir }} ] || mkdir {{ $release_dir }};
	cd {{ $release_dir }};
	git clone {{ $repo }} --branch={{ $branch }} --depth=1 {{ $release }};
@endtask

@task('setup_env', ['on' => $on])
	echo "Setting up environment";
	ln -s {{ $storage_dir }}/.env {{ $release_dir }}/{{ $release }}/.env;
@endtask

@task('setup_storage', ['on' => $on])
	echo "Setting up storage";
	rm {{ $release_dir }}/{{ $release }}/storage -rf;
	ln -s {{ $storage_dir }}/storage {{ $release_dir }}/{{ $release }};
@endtask

@task('build_app', ['on' => $on])
	echo "Building application";
	cd {{ $release_dir }}/{{ $release }};

	echo "Installing npm, composer and bower packages";
    npm-cache install npm composer bower --allow-root;

	echo "Building frontend";
	gulp;

	echo "Migrating database";
	php artisan down;
	php artisan migrate --no-interaction --force -vvv;
	php artisan up;

	echo "Waiting 5 seconds for the application to fully come back up";
	sleep 5;
@endtask

@task('update_permissions', ['on' => $on])
	echo "Updating permissions";
	cd {{ $release_dir }};
	chgrp -R www-data {{ $release }};
	chmod -R ug+rwx {{ $release }};

	chgrp -R www-data {{ $storage_dir }}/storage;
	chmod -R ug+rwx {{ $storage_dir }}/storage;
@endtask

@task('delete_old_releases', ['on' => $on])
	echo "Deleting old releases";
	cd {{ $release_dir }};
	ls -1d release_* | head -n -10 | xargs -d "\n" rm -Rf;
@endtask

@task('update_symlinks', ['on' => $on])
	echo "Updating symlinks";
	ln -nfs {{ $release_dir }}/{{ $release }} {{ $app_dir }};
	chgrp -h www-data {{ $app_dir }};
@endtask

@task('restart_queue', ['on' => $on])
	echo "Restarting queue";
	cd {{ $release_dir }}/{{ $release }};
	php artisan queue:restart;
@endtask
