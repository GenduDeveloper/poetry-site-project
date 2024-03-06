<?php

session_destroy(); // закрываем сессию
header('Location: ?page=index');
