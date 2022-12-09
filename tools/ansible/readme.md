# ТАЙРАЙ Ansible Playbooks

- Version: 0.0.1

## Обязательные требования

- 

- У вас должен быть установлен Ansible, пожалуйста прочтите инструкцию в  [официальной документации](https://docs.ansible.com/ansible/latest/installation_guide/intro_installation.html#) Ниже перечислены шаги для установки `Ansible`под `Linux Ubuntu 20.04`, но актуальность их не гарантированна.
  
  - ```shell
    apt-add-repository -y ppa:ansible/ansible;
    ```
  - ```shell
    apt update -y;
    ```
  - ```shell
    apt install -y ansible;
    ```
  - ```shell
    apt install -y sshpass;
    ```

- На локальном хосте **ДОЛЖЕН** быть установлен интерпретатор `python` версии 3.x и бинарный файл должен быть доступен по пути `/usr/bin/python3`. Пожалуйста прочтите инструкцию в  [официальной документации](https://www.python.org/downloads/) Ниже перечислены шаги для установки `python3`под `Linux Ubuntu 20.04`, но актуальность их не гарантированна.
  
  - ```shell
      apt install -y python3-pip
    ```

- Вы **ДОЛЖНЫ** вручную добавить или обновить `DNS` записи у вашего `DNS провайдера` до того как начнете процесс настройки инфраструктуры. **Сделайте это как можно раньше, чтобы сразу получить валидные TLS сертификаты!**

- Данные автоматизированные Ansible скрипты созданы и протестированы для работы с выделенным сервером под управлением `OS Linux Ubuntu Server 20.04.3 LTS Release: 20.04`  с активным `sshd` демоном, способным принимать внешние подключения. Дистрибутив не должен содержать каких бы то ни было модификаций ядра или предустановленного програмного обеспечения, которое не входит в стандартный пакет поставки дистрибутива.

- Сервер **ДОЛЖЕН ИМЕТЬ** открытые, не блокированные внешним брэндмауэром и не занятые публичные порты `80`, `443`, `9100`, `9101`.

- Сервер **ДОЛЖЕН ИМЕТЬ** возможность первичного подключения по протоколу `SSH` для пользователя `root` <u>с паролем</u>.

- `IP` адрес по которому производится `SSH` подключение должен совпадать с `IP` адресом на который указывает `DNS` запись типа `А` обслуживаемых приложением доменов.

- Минимальные требования по ресурсам для выполнения скриптов без учета дискового пространства для размещения файлов прилождения: `CPU: 2 Core, Memory: 2GB, Disk: 40GB`

## Требования для первичного запуска

- Перед процессом запуска скрипта `Ansible`, вы должны <u>переключиться на соответствующую ветку git</u> !

- Сделайте отдельный `.env` файл для вашего окружения. Например, сделайте `.env.prod` файл для `production` окружения и не забудъте добавить его в `.gitignore`!

- Сделайте отдельный `docker-compose` для вашего окружения. Например, для  `production` окружения назовите его `docker-compose.prod.yml`!

- Проверьте, что ваш `docker-compose.prod.yml` файл использует правильные переменные из `.env.prod` файла!

- Заполните все конфигурационные файлы для `group_vars`, `host_vars`, `vars`

- Проверьте, что вы заполнили все `required` переменные в  `.env.*` файле, который будет включен в  `host_vars/production.yml` конфигурационный файл!

- Для корректной доставки кода через GitLab CI/CD укажите  значения переменных `GITLAB_DEPLOY_USER` и  `GITLAB_DEPLOY_PASSWORD` в `.env.prod` файле. Вы также дожны определить эти переменные в вашем GitLab репозитории  `https://gitlab.com/<YOUR_REPOSITORY_ACCOUNT_NAME>/<YOUR_REPOSITORY>/-/settings/repository` в `Deploy tokens` секции.

- Вы можете заархивировать директорию `storage` для последующей загрузки на удаленный хост, в противном случае на хосте будет создана базовая структура директорий `storage` по умолчанию.

- Вы можете сделать `dump` базы данных database для последующей загрузки на удаленный хост, в противном случае на хосте будут запущены все `migration` и `seed` файлы.

- Запуск `playbooks` необходимо выполнять из директории репозитория `tools/ansible`

## Предопределенные файлы groups, hosts и roles variables

- все groups и hosts объявлены в `./inventory` файле.
- все общие настройки переменных находятся в файле `group_vars/all.yml`
- host `production` содержит host variables в файле file `host_vars/production.yml`
- role `build_and_up_traefik` содержит role variables в файле `roles/build_and_up_traefik/vars/main.yml`
- role `build_and_up_node_exporter_service` содержит role variables в файле `roles/build_and_up_node_exporter_service/vars/main.yml`
- role `build_and_up_cadvisor_service` содержит role variables в файле `roles/build_and_up_cadvisor_service/vars/main.yml`

## Предопределенные playbooks для установки инфраструктуры запуска приложения

### Если вы хотите сконфигурировать вновь созданый сервер, используйте эти playbooks

#### 01 - Доставка публичного ключа

- Доставка публичного `SSH` ключа для последующего соединения без использования пароля. Перед этим ключ должен быть сгенерирован на вашем компьютере.
  
  ```shell
  ansible-playbook ./playbooks/01_add_ssh_keys_playbook.yml -l production
  ```
  
  - Что происходит в `playbook`:
    
    - передача на удаленный хост публичного ключа
  
  #### 02 - Подготовка общей инфраструктуры

- Подготовка общей инфраструктуры, на удаленный хост уже должен быть добавлен ваш публичный ключ для установки SSH соединения.
  
  ```shell
  ansible-playbook ./playbooks/02_production_preparation_playbook.yml -l production
  ```
  
  - Что происходит в `playbook`:
    - Установка необходимых библиотек и програмного обеспечения
    - Установка `docker` и `docker-compose`
    - Установка запрета `SSH` подключения по паролю, разрешены только полключения через публичные `SSH` ключи.
    - Добавление публичного ключа для подключения gitlab
    - Создание файла подкачки
    - Установка сетевого ПО
    - Конфигурирование правил Uncomplicated Firewall для портов 80, 443, 22
    - Конфигурирование fail2ban
  
  #### 03 - Установка Тraefik Proxy

- Установка [Тraefik Proxy](https://traefik.io/traefik/) <u>Выполняется после того, как выполнен `playbook` (02) для установки инфраструктуры запуска приложения.</u>
  
  - Убедитесь, что вы заполнили файл с переменными `roles/build_and_up_traefik/vars/main.yml`
  
  ```shell
  ansible-playbook ./playbooks/03_traefik_setup_playbook.yml -l production
  ```
  
  - Что происходит в `playbook`:
    - Сборка и запуск docker контейнера Traefik
    - Создание внутренней `docker` сети 'traefik-public'
    - Добавление реквизитов для базовой авторизации

## Предопределенные playbooks для установки laravel приложения

#### 04 - Разворачивание ***production*** сервера laravel приложения

- Разворачивание ***production*** сервера, где `Traefik` используется в качестве обратного прокси. <u>Выполняется после того, как выполнены `playbooks` (02) для установки инфраструктуры запуска приложения и (03) установка Тraefik Proxy.</u>
  
  ```shell
    ansible-playbook ./playbooks/04_production_deploy_with_traefik_playbook.yml -l production
  ```
  
  ***N.B.: другие аргументы не требуются, поскольку учетные данные конфигурируются один раз в `host_vars/production.yml file`***
  
  - Что происходит в `playbook`:
    - Создаются все нужные  docker сети
    - Собираются и запускаются все нужные контейнеры
    - Создается и импортируется база данных
    - Доставляется и запускается приложение

## Предопределенные playbooks для установки сервисов мониторинга

#### 05 - Установка сервиса мониторинга ресурсов хоста

- Установка сервисов мониторинга выполняется после того, как запущен и настроен хост для приема данных о мониторинге (Prometheus + Grafana).

- Убедитесь, что вы заполнили файл с переменными `roles/build_and_up_node_exporter_service/vars/main.yml`

- Что происходит в `playbook`:
  
  - Скачивается и запускается контейнер node_exporter на порту `9100`
  
  ```shell
  ansible-playbook ./playbooks/05_monitoring_node_exporter_setup_playbook.yml -l production
  ```
  
  #### 06 - Установка сервиса мониторинга docker контейнеров

- Установка сервисов мониторинга контейнеров выполняется после того, как запущен и настроен хост для приема данных о мониторинге (Prometheus + Grafana).

- Убедитесь, что вы заполнили файл с переменными `roles/build_and_up_cadvisor_service/vars/main.yml`

- Что происходит в `playbook`:
  
  - Скачивается и запускается контейнер cadvisor на порту `9101`
  
  ```shell
  ansible-playbook ./playbooks/06_monitoring_cadvisor_setup_playbook.yml -l production
  ```

## Тестовый запуск playbook

- При тестовом воспроизведении (режим сухого прогона)  вы **ДОЛЖНЫ** запустить `playbook` c аргументом `-C`.
  
  ```shell
  ansible-playbook -C ./playbooks/04_production_deploy_with_traefik_playbook.yml
  ```