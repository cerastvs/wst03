<?php

function basePath($path = '')
{
    return __DIR__ . '/' . ltrim($path, '/');
}

/**
 * load new
 * param string $NAME
 * return void **/
function loadView($name, $data = [])
{
    $viewPath = basePath("App/views/{$name}.view.php");
    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "View {$name} not found";
    }
}

function loadPartial($name, $data = [])
{
    $partialPath = basePath("App/views/partials/{$name}.php");
    if (file_exists($partialPath)) {
        extract($data);
        require $partialPath;
    } else {
        echo "partial {$name} not found";
    }
}
function inspect($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}
function formatSalary($salary)
{
    return '₱' . number_format(floatval($salary));
}
function inspectAndDie($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

/**
 *sanitize data
 *@param string $dirty
 *return string
 */
function sanitize($dirty)
{
    return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS);
}
/**
 * redirect to a given url
 * @param string $url
 * @return void
 */
function redirect($url)
{
    header("Location: {$url}");
}
