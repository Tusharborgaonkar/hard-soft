<?php
DB::enableQueryLog();
$q = App\Models\Question::find(2);
$q->options()->delete();
foreach([['gu'=>'1','en'=>'222'],['gu'=>'2','en'=>'333']] as $opt) {
    $q->options()->create(['option_text_gu'=>$opt['gu'], 'option_text_en'=>$opt['en'], 'order'=>0]);
}
print_r(DB::getQueryLog());
print_r($q->options()->get()->toArray());
