<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Option;
use App\Models\Section;
use Illuminate\Support\Facades\File;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/questions.md');
        if (!File::exists($path)) return;

        $content = File::get($path);
        $sectionsData = explode('# Section', $content);
        array_shift($sectionsData); // remove prefix before first section

        $qOrder = 1;
        $sOrder = 1;
        foreach ($sectionsData as $sectionContent) {
            $lines = explode("\n", trim($sectionContent));
            $header = array_shift($lines);
            
            // Extract section info: " 1: સામાજિક (Social)"
            preg_match('/^\s*\d+:\s*(.*?)\s*\((.*?)\)/u', $header, $secMatches);
            $secGu = $secMatches[1] ?? 'વિભાગ';
            $secEn = $secMatches[2] ?? 'Section';

            $section = Section::firstOrCreate(
                ['title_gu' => $secGu],
                ['title_en' => $secEn, 'order' => $sOrder++]
            );

            $questions = explode('## ', implode("\n", $lines));
            array_shift($questions);

            foreach ($questions as $qData) {
                $qLines = explode("\n", trim($qData));
                $qHeader = array_shift($qLines);
                
                // Q Header: "Q1: નામ (Full Name)"
                preg_match('/^(.*?):\s*(.*?)\s*\((.*?)\)/u', $qHeader, $qMatches);
                $qGu = $qMatches[2] ?? 'પ્રશ્ન';
                $qEn = $qMatches[3] ?? 'Question';

                $qMeta = [];
                $optionsList = [];
                $isOptionAttribute = false;

                foreach ($qLines as $l) {
                    $l = trim($l);
                    if (str_starts_with($l, 'options:')) {
                        $isOptionAttribute = true; continue;
                    }
                    if ($isOptionAttribute && str_starts_with($l, '- ')) {
                        $optionsList[] = substr($l, 2);
                        continue;
                    }
                    if (str_contains($l, ':')) {
                        $parts = explode(':', $l, 2);
                        $qMeta[trim($parts[0])] = trim($parts[1]);
                    }
                }

                $question = Question::create([
                    'section_id' => $section->id,
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
