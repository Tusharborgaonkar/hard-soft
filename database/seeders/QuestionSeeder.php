<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Support\Facades\File;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/questions.md');
        if (!File::exists($path)) return;

        $content = File::get($path);
        $sections = explode('# Section', $content);
        array_shift($sections); // remove prefix before first section

        $qOrder = 1;
        foreach ($sections as $sectionData) {
            $lines = explode("\n", trim($sectionData));
            $header = array_shift($lines);
            
            // Extract section info: " 1: સામાજિક (Social)"
            preg_match('/^\s*\d+:\s*(.*?)\s*\((.*?)\)/u', $header, $secMatches);
            $secGu = $secMatches[1] ?? 'વિભાગ';
            $secEn = $secMatches[2] ?? 'Section';

            $questions = explode('## ', implode("\n", $lines));
            array_shift($questions);

            foreach ($questions as $qData) {
                $qLines = explode("\n", trim($qData));
                $qHeader = array_shift($qLines);
                
                // Q Header: "Q1: નામ (Full Name)"
                preg_match('/^(.*?):\s*(.*?)\s*\((.*?)\)/u', $qHeader, $qMatches);
                $qName = $qMatches[1] ?? 'Q';
                $qGu = $qMatches[2] ?? 'પ્રશ્ન';
                $qEn = $qMatches[3] ?? 'Question';

                $qMeta = [];
                $optionsList = [];
                $isOption = false;

                foreach ($qLines as $l) {
                    $l = trim($l);
                    if (str_starts_with($l, 'options:')) {
                        $isOption = true; continue;
                    }
                    if ($isOption && str_starts_with($l, '- ')) {
                        $optionsList[] = substr($l, 2);
                        continue;
                    }
                    if (str_contains($l, ':')) {
                        $parts = explode(':', $l, 2);
                        $qMeta[trim($parts[0])] = trim($parts[1]);
                    }
                }

                $question = Question::create([
                    'section_name' => "Section " . ($qOrder),
                    'section_title_gu' => $secGu,
                    'section_title_en' => $secEn,
                    'question_text_gu' => $qGu,
                    'question_text_en' => $qEn,
                    'type' => $qMeta['type'] ?? 'text',
                    'is_required' => ($qMeta['required'] ?? 'false') === 'true',
                    'order' => $qOrder++,
                ]);

                foreach ($optionsList as $idx => $opt) {
                    preg_match('/(.*?)\s*\((.*?)\)/u', $opt, $optMatches);
                    Option::create([
                        'question_id' => $question->id,
                        'option_text_gu' => $optMatches[1] ?? $opt,
                        'option_text_en' => $optMatches[2] ?? null,
                        'order' => $idx + 1,
                    ]);
                }
            }
        }
    }
}
