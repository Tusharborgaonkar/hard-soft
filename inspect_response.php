<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Response;
$id = 3; // The ID mentioned by the user
$response = Response::with('answers')->find($id);

if ($response) {
    echo "Response ID: " . $response->id . "\n";
    foreach ($response->answers as $ans) {
        if (strpos($ans->answer_value, '[{') !== false) {
            echo "Question ID: " . $ans->question_id . "\n";
            echo "Raw Value: " . $ans->answer_value . "\n";
            print_r(json_decode($ans->answer_value, true));
        }
    }
} else {
    echo "Response $id not found.\n";
}
