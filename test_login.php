<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/internal/login', 'GET');
$response = $kernel->handle($request);

echo "--- GET HEADERS ---\n";
foreach ($response->headers->all() as $key => $values) {
    echo $key . ": " . implode(", ", $values) . "\n";
}

$cookies = $response->headers->getCookies();
$sessionCookieName = '';
$laravelSession = '';
$csrfToken = '';

$content = $response->getContent();
if (preg_match('/name="_token" value="([^"]+)"/', $content, $matches)) {
    $csrfToken = $matches[1];
}

foreach ($cookies as $cookie) {
    if (strpos($cookie->getName(), 'session') !== false) {
        $sessionCookieName = $cookie->getName();
        $laravelSession = $cookie->getValue();
    }
}

echo "Session Cookie: " . $sessionCookieName . "=" . $laravelSession . "\n";
echo "CSRF Token: " . $csrfToken . "\n";

$request2 = Illuminate\Http\Request::create('/internal/login', 'POST', [
    'email' => 'superadmin@gmail.com',
    '12345678' => '12345678',
    '_token' => $csrfToken,
]);
if ($sessionCookieName) {
    $request2->cookies->set($sessionCookieName, $laravelSession);
}

$response2 = $kernel->handle($request2);
echo "\n--- POST STATUS ---\n";
echo "Status: " . $response2->getStatusCode() . "\n";
echo "Redirect: " . $response2->headers->get('Location') . "\n";

$content2 = $response2->getContent();
if ($response2->getStatusCode() == 419) {
    echo "419 Page Expired Error encountered!\n";
} elseif ($response2->getStatusCode() == 302) {
    echo "Redirect Location: " . $response2->headers->get('Location') . "\n";
} else {
    echo "Other response: " . substr(strip_tags($content2), 0, 100) . "...\n";
}
