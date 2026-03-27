<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Section;
use App\Models\Question;
use App\Models\Option;
use App\Models\Response;
use App\Models\Answer;

class ResearchQuestionnaireSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Option::truncate();
        Answer::truncate();
        Question::truncate();
        Section::truncate();
        Response::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            // Section 1
            [
                'title_gu' => 'વિભાગ – 1: સામાજિક અને આર્થિક માહિતી',
                'title_en' => 'Section 1: Social and Economic Information',
                'questions' => [
                    ['text_gu' => '1. નામ:', 'text_en' => 'Name', 'type' => 'text'],
                    ['text_gu' => '2. વતન:', 'text_en' => 'Hometown', 'type' => 'table', 'meta' => ['columns' => 'ગામ,શહેર,તાલુકો,જિલ્લા', 'rows' => '1']],
                    ['text_gu' => '3. ઉંમર:', 'text_en' => 'Age', 'type' => 'radio', 'options' => ['20 થી 25 વર્ષ' => '20 to 25 yrs', '26 થી 30 વર્ષ' => '26 to 30 yrs', '31 થી 35 વર્ષ' => '31 to 35 yrs', '35 વર્ષથી ઉપર' => 'Above 35 yrs']],
                    ['text_gu' => '4. જાતિ-પેટા જાતિ:', 'text_en' => 'Caste-Subcaste', 'type' => 'text'],
                    ['text_gu' => '5. ધર્મ:', 'text_en' => 'Religion', 'type' => 'text'],
                    ['text_gu' => '6. શાળાનું નામ:', 'text_en' => 'School Name', 'type' => 'text'],
                    ['text_gu' => '7. શાળાનું સરનામું:', 'text_en' => 'School Address', 'type' => 'table', 'meta' => ['columns' => 'ગામ,શહેર,તાલુકો,જિલ્લો', 'rows' => '1']],
                    ['text_gu' => '8. તમે કેટલી ભાષા જાણો છો?', 'text_en' => 'Languages known', 'type' => 'checkbox', 'options' => ['ગુજરાતી' => 'Gujarati', 'હિન્દી' => 'Hindi', 'અંગ્રેજી' => 'English', 'અન્ય' => 'Other']],
                    ['text_gu' => '9. વૈવાહિક સ્થિતિ:', 'text_en' => 'Marital Status', 'type' => 'radio', 'options' => ['અપરિણીત' => 'Unmarried', 'પરિણીત' => 'Married', 'છૂટાછેડા' => 'Divorced', 'વિધવા' => 'Widow', 'ત્યક્તા' => 'Separated']],
                    ['text_gu' => '10. શૈક્ષણિક લાયકાત:', 'text_en' => 'Educational Qualification', 'type' => 'checkbox', 'options' => ['સ્નાતક' => 'Graduate', 'અનુસ્નાતક' => 'Post-Graduate', 'પી.ટી.સી.' => 'PTC', 'બી.એડ.' => 'B.Ed.', 'એમ.એડ.' => 'M.Ed.', 'સી.પી.એડ./ડી.પી.એડ.' => 'CP.Ed./DP.Ed.', 'એમ.ફિલ.' => 'M.Phil.', 'પી.એચ.ડી.' => 'Ph.D.', 'અન્ય' => 'Other']],
                    ['text_gu' => '11. શૈક્ષણિક સંસ્થાનો વિભાગ:', 'text_en' => 'Educational Section', 'type' => 'radio', 'options' => ['માધ્યમિક વિભાગ (ધોરણ – 9 થી 10)' => 'Secondary Section (Std. 9-10)','ઉચ્ચતર માધ્યમિક વિભાગ (ધોરણ – 11 થી 12)' => 'Higher Secondary Section (Std. 11-12)']],
                    ['text_gu' => '12. શાળાનું માધ્યમ:', 'text_en' => 'School Medium', 'type' => 'radio', 'options' => ['ગુજરાતી' => 'Gujarati', 'હિન્દી' => 'Hindi', 'અંગ્રેજી' => 'English']],
                    ['text_gu' => '13. શૈક્ષણિક અનુભવ:', 'text_en' => 'Teaching Experience', 'type' => 'radio', 'options' => ['1 વર્ષથી ઓછી' => 'Less than 1 year', '1 થી 5 વર્ષ' => '1 to 5 yrs', '6 વર્ષથી 10 વર્ષ' => '6 to 10 yrs', '11 વર્ષથી 20 વર્ષ' => '11 to 20 yrs', '21 વર્ષથી વધારે' => 'Above 21 yrs']],
                    ['text_gu' => '14. કુટુંબનો પ્રકાર:', 'text_en' => 'Family Type', 'type' => 'radio', 'options' => ['સંયુક્ત કુટુંબ' => 'Joint Family', 'વિભક્ત કુટુંબ' => 'Nuclear Family']],
                    ['text_gu' => '15. વાર્ષિક આવક:', 'text_en' => 'Annual Income', 'type' => 'text'],
                    ['text_gu' => '16. કૌટુંબિક માહિતી : કુટુંબની માહિતી દર્શાવતું પત્રક', 'text_en' => 'Family Information', 'type' => 'table', 'meta' => ['columns' => 'નામ,સંબંધ,ઉંમર,શિક્ષણ,વૈવાહિક સ્થિતિ,વ્યવસાય,વાર્ષિક કુલ આવક', 'rows' => '10']],
                ]
            ],
            // Section 2
            [
                'title_gu' => 'વિભાગ – 2: શિક્ષકનું વ્યક્તિત્વ અને કામની પરિસ્થિતિ',
                'title_en' => 'Section 2: Teacher Personality and Work Conditions',
                'questions' => [
                    ['text_gu' => '1. તમને તમારી શિક્ષકની નોકરીથી આત્મસંતોષ છે ?', 'text_en' => 'Self satisfaction from job?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો ના હોય, તો કારણ જણાવો:', 'text_en' => 'If no, reason:', 'type' => 'text'],
                    ['text_gu' => '2. નોકરી કરવા પાછળના કારણો જણાવો.', 'text_en' => 'Reasons for doing job', 'type' => 'checkbox', 'options' => ['આર્થિક જરૂરિયાત માટે' => 'For financial need', 'આત્મનિર્ભરતા માટે' => 'For self-reliance', 'શોખ પૂરો કરવા માટે' => 'To fulfill hobby', 'ભવિષ્યની સલામતી માટે' => 'For future security', 'ઉચ્ચ જીવનશૈલી માટે' => 'For higher lifestyle', 'પોતે મેળવેલ શિક્ષણની ઉપયોગિતા માટે' => 'To utilize education']],
                    ['text_gu' => '3. તમારા કાર્યની સૌથી વધારે કદર કોણ કરે છે ?', 'text_en' => 'Who appreciates your work most?', 'type' => 'checkbox', 'options' => ['પતિ' => 'Husband', 'સાસુ' => 'Mother-in-law', 'સસરા' => 'Father-in-law', 'સંતાનો' => 'Children', 'અન્ય (સાસરિયા)' => 'Other (In-laws)', 'માતા' => 'Mother', 'પિતા' => 'Father', 'ભાઈ' => 'Brother', 'બહેન' => 'Sister', 'મિત્રો (પિયર પક્ષ)' => 'Friends (Maternal)']],
                    ['text_gu' => '4. નોકરીના કારણે તમારું સન્માન/આત્મસન્માન વધ્યું છે ?', 'text_en' => 'Job increased respect?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો શેમાં ?', 'text_en' => 'If yes, where?', 'type' => 'checkbox', 'options' => ['ઘર' => 'Home', 'સગાસંબંધીઓ' => 'Relatives', 'પડોશમાં' => 'Neighborhood', 'સમાજ' => 'Society', 'કુટુંબ' => 'Family', 'મિત્ર વર્તુળ' => 'Friend Circle', 'જાતિ' => 'Caste', 'અન્ય' => 'Other']],
                    ['text_gu' => '5. તમારી શિક્ષક તરીકેની નોકરીથી તમારા મિત્રોને ઈર્ષા થાય છે ?', 'text_en' => 'Friends jealous?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો શા માટે ?', 'text_en' => 'If yes, why?', 'type' => 'checkbox', 'options' => ['સરકારી નોકરી મળી છે અને શાળામાં માન છે.' => 'Got govt job and respect at school', 'મિત્રો કરતા પગાર ધોરણ ઊંચું છે.' => 'Salary is higher than friends', 'શિક્ષકની નોકરીમાં બીજા મિત્રો કરતા તમને વેકેશન વધારે મળે છે.' => 'You get more vacations in teaching', 'નોકરી વતનમાં છે અને કામના કલાકો ઓછા છે.' => 'Job in hometown, less work hours', 'નોકરીમાં વિદ્યાર્થીઓ તરફથી શાળામાં પ્રેમ અને લાગણી વધારે મળે છે.' => 'More love & affection from students']],
                    ['text_gu' => '6. આપ કયા વિભાગમાં કાર્ય કરો છો ?', 'text_en' => 'Which section do you work in?', 'type' => 'radio', 'options' => ['ધોરણ – 9 અને ધોરણ – 10 માં શિક્ષક તરીકેની કામગીરી' => 'Class 9-10 Teacher', 'ધોરણ – 11 અને ધોરણ – 12 માં વિષયક શિક્ષક તરીકેની કામગીરી' => 'Class 11-12 Subject Teacher']],
                    ['text_gu' => '7. વિષયને લગતી તૈયારી કરવા માટે કેટલો સમય આપો છો ?', 'text_en' => 'Time given for subject preparation?', 'type' => 'radio', 'options' => ['એક કલાક' => 'One hour', 'બે કલાક' => 'Two hours', 'ત્રણ કલાક' => 'Three hours', 'ચાર કલાક' => 'Four hours', 'તૈયારીની કોઈ જરૂર નથી' => 'No preparation needed']],
                    ['text_gu' => '8. વર્ગમાં શિક્ષણકાર્ય કરતી વખતે તમારા વિષયને લગતા સંદર્ભ પુસ્તકોનો ઉપયોગ કરો છો ?', 'text_en' => 'Do you use reference books?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કયા કયા ?', 'text_en' => 'If yes, which ones?', 'type' => 'checkbox', 'options' => ['શિક્ષક આવૃત્તિ' => 'Teacher edition', 'સંદર્ભસાહિત્ય' => 'Reference material', 'ગાઈડ' => 'Guide', 'અન્ય' => 'Other']],
                    ['text_gu' => 'જો અન્ય હોય તો જણાવો:', 'text_en' => 'If other, specify:', 'type' => 'text'],
                    ['text_gu' => '9. તમે ફુરસદના સમયમાં વાંચન કરો છો ?', 'text_en' => 'Do you read in free time?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કયા પ્રકારના પુસ્તકોનું વાંચન કરો છો ?', 'text_en' => 'If yes, what type of books?', 'type' => 'checkbox', 'options' => ['પોતાના વિષયને લગતા' => 'Subject related', 'શાળા વ્યવસ્થાપન' => 'School management', 'વર્ગમાં શિક્ષણને લગતા' => 'Class teaching related', 'નવલકથા' => 'Novel', 'જીવન ઘડતર અને વ્યક્તિત્વ વિકાસ' => 'Life & personality dev', 'બાળ મનોઃવિજ્ઞાનને લગતા' => 'Child psychology', 'શિક્ષણના સિદ્ધાંતો' => 'Education principles', 'શિક્ષણ પદ્ધતિશાસ્ત્રને લગતા' => 'Teaching methodology']],
                    ['text_gu' => '10. નવરાશ કે રજાના સમયમાં તમે શું કરો છો ?', 'text_en' => 'What do you do in holidays?', 'type' => 'checkbox', 'options' => ['વાંચન' => 'Reading', 'બાળકો સાથે' => 'With children', 'બહાર ફરવા જવું' => 'Going out', 'સંગીત' => 'Music', 'ગપ્પા મારવા' => 'Gossiping', 'ચિત્રકામ' => 'Drawing', 'ટી.વી. જોવું' => 'Watching TV', 'ઘર સફાઈ' => 'House cleaning', 'લેખન' => 'Writing']],
                    ['text_gu' => '11. તમારી નોકરીનું સ્થળ રહેઠાણથી કેટલું દૂર છે ?', 'text_en' => 'Job distance from residence?', 'type' => 'radio', 'options' => ['2 કિલોમીટર' => '2 km', '2 થી 5 કિલોમીટર' => '2 to 5 km', '5 થી 10 કિલોમીટર' => '5 to 10 km', '10 કિલોમીટર થી વધારે' => 'More than 10 km']],
                    ['text_gu' => '12. તમે નોકરીના ગામમાં જ રહો છો કે અપ-ડાઉન કરો છો ?', 'text_en' => 'Stay at job location or up-down?', 'type' => 'radio', 'options' => ['નોકરીના ગામમાં જ રહું છું' => 'Stay at job town', 'અપ-ડાઉન કરું છું' => 'Commute Up-down']],
                    ['text_gu' => '13. શાળાએ આવવા-જવા માટે વાહનનો ઉપયોગ કરો છો ?', 'text_en' => 'Use vehicle to commute?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, હોય તો:', 'text_en' => 'If yes, which vehicle?', 'type' => 'checkbox', 'options' => ['બસ' => 'Bus', 'રિક્ષા' => 'Rickshaw', 'ટુ વ્હીલર' => 'Two-wheeler', 'ફોર વ્હીલર' => 'Four-wheeler']],
                    ['text_gu' => '14. નોકરીમાં અપ-ડાઉનના કારણે કોઈ શારીરિક-માનસિક તકલીફ અનુભવવી પડે છે ?', 'text_en' => 'Physical-mental trouble due to up-down?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '15. તમને કયા પ્રકારની તકલીફ પડે છે ?', 'text_en' => 'What kind of trouble?', 'type' => 'checkbox', 'options' => ['અપ-ડાઉનની' => 'Up-down commuting', 'સમયની' => 'Time constraint', 'ઘરમાં' => 'At home', 'શાળામાં' => 'In school', 'સહકર્મચારી સાથે' => 'With colleagues', 'આચાર્ય સાથે' => 'With Principal']],
                    ['text_gu' => '16. વર્ગમાં શિક્ષણકાર્ય કરતી વખતે આપને કોઈ સમસ્યા નડે છે ?', 'text_en' => 'Problem while teaching in class?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કઈ પ્રકારની ?', 'text_en' => 'If yes, what type?', 'type' => 'text'],
                ]
            ],
            // Section 3
            [
                'title_gu' => 'વિભાગ – 3: શિક્ષક અને વિદ્યાર્થી વચ્ચેના આંતરસંબંધો',
                'title_en' => 'Section 3: Teacher-Student Interrelations',
                'questions' => [
                    ['text_gu' => '1. શિક્ષક તરીકે તમે વિદ્યાર્થી સાથે કેવા પ્રકારના સંબંધો રાખવા જોઈએ ?', 'text_en' => 'What kind of relation with students?', 'type' => 'radio', 'options' => ['આત્મીયતાના' => 'Intimate', 'મર્યાદિત' => 'Limited', 'મધ્યમ' => 'Moderate', 'ઉપચારિક' => 'Formal']],
                    ['text_gu' => '2. હાલના આધુનિક અને કમ્પ્યુટર યુગના સમયમાં શિક્ષકનું સમાજમાં સ્થાન કેવું છે ?', 'text_en' => "Teacher's place in modern society?", 'type' => 'radio', 'options' => ['ઉચ્ચ સ્થાન' => 'High', 'મધ્યમ સ્થાન' => 'Middle', 'નિમ્ન સ્થાન' => 'Low']],
                    ['text_gu' => '3. શિક્ષક પાસે માર્ગદર્શન મેળવવા વિદ્યાર્થીઓ પૂર્વમંજૂરી કેવી રીતે મેળવે છે ?', 'text_en' => 'How students get permission to meet?', 'type' => 'radio', 'options' => ['અગાઉથી સમય મેળવીને' => 'Prior appointment', 'ગમે ત્યારે' => 'Anytime', 'તાત્કાલિક' => 'Immediately']],
                    ['text_gu' => '4. વિદ્યાર્થીઓ કયા પ્રકારના પ્રશ્નો લઈને તમારી પાસે આવે છે ?', 'text_en' => 'What type of problems students bring?', 'type' => 'checkbox', 'options' => ['શૈક્ષણિક' => 'Educational', 'અંગત' => 'Personal', 'મિત્ર વર્તુળના પ્રશ્નો' => 'Friends circle issues', 'કૌટુંબિક' => 'Family issues']],
                    ['text_gu' => '5. શિક્ષકનું વિદ્યાર્થીઓ અંગેનું અભિપ્રાય વિષેનું મતદાન', 'text_en' => "Teacher's opinion about students", 'type' => 'checkbox', 'options' => ['જિજ્ઞાસુ' => 'Curious', 'અભ્યાસુ' => 'Studious', 'રમતીયાળ' => 'Playful', 'ચંચળ' => 'Restless', 'સંસ્કારી' => 'Cultured', 'અન્ય' => 'Other']],
                    ['text_gu' => '6. શિક્ષક દ્વારા વિદ્યાર્થીઓને દરરોજ માર્ગદર્શન કરવામાં આવે છે ?', 'text_en' => 'Are students guided daily?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '7. વિદ્યાર્થી દ્વારા શિક્ષકનો આદર થાય છે ?', 'text_en' => 'Do students respect teachers?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો ક્યારે:', 'text_en' => 'If yes, when:', 'type' => 'radio', 'options' => ['દરરોજ' => 'Daily', 'ક્યારેક' => 'Sometimes', 'પ્રસંગોપાત' => 'Occasionally']],
                    ['text_gu' => '8. શિક્ષક દ્વારા વિદ્યાર્થીઓને સહઅભ્યાસિક પ્રવૃત્તિમાં મદદ અને માર્ગદર્શન મળે છે ?', 'text_en' => 'Do teachers guide in co-curriculars?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કેવું ?', 'text_en' => 'If yes, what kind?', 'type' => 'checkbox', 'options' => ['કરિયર માર્ગદર્શન' => 'Career guidance', 'વ્યક્તિગત વિકાસ' => 'Personal dev', 'પ્રોજેક્ટ વર્ક' => 'Project work', 'મૂલ્ય શિક્ષણ અને જીવન ઘડતર' => 'Value education']],
                    ['text_gu' => '9. શાળાના આર્થિક રીતે પછાત અને નબળા વર્ગના બાળકોને તમે કોઈ પ્રકારની મદદ કરો છો ?', 'text_en' => 'Do you help poor students?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કયા પ્રકારની ?', 'text_en' => 'If yes, what type of help?', 'type' => 'checkbox', 'options' => ['સ્ટેશનરી' => 'Stationery', 'કપડા' => 'Clothes', 'ઘરની આર્થિક મદદ' => 'Financial help']],
                    ['text_gu' => '10. એક શિક્ષક તરીકે તમે ક્યારે વિદ્યાર્થીઓને તેમની સમસ્યા કે મૂંઝવણમાં માર્ગદર્શન કરો છો ?', 'text_en' => 'When do you guide students in trouble?', 'type' => 'radio', 'options' => ['હંમેશા' => 'Always', 'ક્યારેક' => 'Sometimes', 'પ્રસંગોપાત' => 'Occasionally']],
                    ['text_gu' => '11. એક શિક્ષક તરીકે શાળાના બાળકો કયા સામાજિક વાતાવરણમાંથી આવે છે તેની જાણકારી હોવી જોઈએ ?', 'text_en' => 'Should teacher know social background?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો શા માટે ?', 'text_en' => 'If yes, why?', 'type' => 'text'],
                    ['text_gu' => '12. શાળાના બાળકોની વિદ્યાર્થી તરીકેની છાપ કેવી હોવી જોઈએ ?', 'text_en' => 'Impression of school children?', 'type' => 'checkbox', 'options' => ['આદર્શિત' => 'Idealistic', 'અનુશાસિત' => 'Disciplined', 'બહિર્મુખી' => 'Extrovert', 'ઉદ્દત' => 'Insolent']],
                    ['text_gu' => '13. વિદ્યાર્થીઓ સાથેના આંતરસંબંધો સુમેળભર્યા અને સહકારાત્મક રહે તે માટે શિક્ષકે શાળાના બધા બાળકોને આવકારવા અને સ્વીકારવા જોઈએ ?', 'text_en' => 'Should teacher welcome and accept all children for harmony?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                ]
            ],
            // Section 4
            [
                'title_gu' => 'વિભાગ – 4: શિક્ષક અને સહકર્મચારી વચ્ચેના આંતરસંબંધો',
                'title_en' => 'Section 4: Teacher-Colleague Interrelations',
                'questions' => [
                    ['text_gu' => '1. સહકર્મચારી સાથેના તમારા આંતરસંબંધો કયા પ્રકારના છે ?', 'text_en' => 'Relation with colleagues?', 'type' => 'radio', 'options' => ['હકારાત્મક' => 'Positive', 'નકારાત્મક' => 'Negative']],
                    ['text_gu' => '2. સહકર્મચારી તમને તમારા કામમાં મદદ કરે તેવી અપેક્ષા રાખો છો ?', 'text_en' => 'Expect help from colleagues?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કેવા કામમાં ?', 'text_en' => 'If yes, in what work?', 'type' => 'text'],
                    ['text_gu' => '3. શાળાના બધા શિક્ષકો સાથે તમે સામાજિક સંબંધો બંધાવાનું પસંદ કરશો ?', 'text_en' => 'Will you build social relation with all teachers?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '4. સહકર્મચારી મિત્રો તમારી સાથે સહકારપૂર્ણ વ્યવહાર કરે છે ?', 'text_en' => 'Do colleagues cooperate with you?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '5. તમારી સાથે સહકર્મચારીની વર્તણૂક તમારી દૃષ્ટિએ યોગ્ય છે ?', 'text_en' => 'Is colleague behavior appropriate?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '6. તમે સહકર્મચારીને તેમના કામમાં મદદ કરો છો ?', 'text_en' => 'Do you help colleagues in work?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કેવા કામમાં ?', 'text_en' => 'If yes, in what work?', 'type' => 'text'],
                    ['text_gu' => '7. તમારી સાથેના વર્તનમાં સહકર્મચારી માન-મર્યાદા રાખે છે ?', 'text_en' => 'Do colleagues maintain respect?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '8. તમારે સહકર્મચારી સાથે વાદ-વિવાદ કે ઝઘડો થાય છે ?', 'text_en' => 'Do you argue with colleagues?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કેવા પ્રકારના ?', 'text_en' => 'If yes, what type?', 'type' => 'text'],
                    ['text_gu' => '9. સહકર્મચારી સાથે લગ્ન અંગે આપનો અભિપ્રાય કેવો છે ?', 'text_en' => 'Opinion on marrying a colleague?', 'type' => 'radio', 'options' => ['લગ્ન કરવા જોઈએ' => 'Should marry', 'લગ્ન ન કરવા જોઈએ' => 'Should not marry']],
                    ['text_gu' => '10. સહકર્મચારીનો વ્યવહાર તમારી સાથે મિત્રતાપૂર્ણ છે ?', 'text_en' => 'Is colleague behavior friendly?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                ]
            ],
            // Section 5
            [
                'title_gu' => 'વિભાગ – 5: શિક્ષક અને આચાર્ય વચ્ચેના આંતરસંબંધો',
                'title_en' => 'Section 5: Teacher-Principal Interrelations',
                'questions' => [
                    ['text_gu' => '1. તમારા આચાર્ય સાથેના સંબંધ કેવા છે ?', 'text_en' => 'Relation with Principal?', 'type' => 'radio', 'options' => ['હકારાત્મક' => 'Positive', 'નકારાત્મક' => 'Negative']],
                    ['text_gu' => 'જો હકારાત્મક તો કેવા પ્રકારના ?', 'text_en' => 'If positive, what type?', 'type' => 'text'],
                    ['text_gu' => 'જો નકારાત્મક તો કેવા પ્રકારના ?', 'text_en' => 'If negative, what type?', 'type' => 'text'],
                    ['text_gu' => '2. આચાર્ય સાથેની તમારી વ્યવહાર સહકારસભર રહે છે ?', 'text_en' => 'Cooperative behavior with Principal?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '3. શાળીય નિયંત્રણ લેતી વખતે શિક્ષકોનો અભિપ્રાય લેવામાં આવે છે ?', 'text_en' => 'Teachers opinion taken during school control?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '4. શાળા વિકાસના કાર્યોમાં આચાર્ય તમારા દ્વારા કરાયેલ સૂચનોને માન્ય ગણવી અમલમાં મૂકે છે ?', 'text_en' => 'Does Principal implement your suggestions?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '5. આચાર્ય દ્વારા તમારી સાથે ભેદભાવ રાખવામાં આવે છે ?', 'text_en' => 'Does Principal discriminate against you?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો શા માટે ?', 'text_en' => 'If yes, why?', 'type' => 'text'],
                    ['text_gu' => '6. આચાર્ય દ્વારા તમને શિક્ષણકાર્યમાં માર્ગદર્શન મળે છે ?', 'text_en' => 'Principal guides you in teaching?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '7. આચાર્ય દ્વારા સોંપેલ કાર્ય તમે ખંત અને ઉત્સાહપૂર્વક પૂર્ણ કરો છો ?', 'text_en' => 'Complete work assigned by Principal enthusiastically?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો ના, તો શા માટે ?', 'text_en' => 'If no, why?', 'type' => 'text'],
                    ['text_gu' => '8. તમારા કાર્યમાં આચાર્ય તમને મદદરૂપ બને છે ?', 'text_en' => 'Is Principal helpful in your work?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કયા કાર્યમાં ?', 'text_en' => 'If yes, in what work?', 'type' => 'text'],
                    ['text_gu' => '9. આચાર્ય પ્રત્યે તમે આદરભાવ રાખો છો ?', 'text_en' => 'Do you respect Principal?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '10. આદર્શ આચાર્ય અંગે આપનો અભિપ્રાય કેવો છે ?', 'text_en' => 'Opinion about Ideal Principal?', 'type' => 'checkbox', 'options' => ['આચાર્યનું વ્યક્તિત્વ પ્રભાવશાળી હોવું જોઈએ' => 'Personality should be impressive', 'આચાર્ય સ્વયં શિસ્તને આવકારતા હોવા જોઈએ' => 'Should welcome self-discipline', 'સહકર્મચારી સાથે સહકારપૂર્ણ વર્તન હોવું જોઈએ' => 'Cooperative behavior', 'આચાર્યમાં આત્મવિશ્વાસ હોવો જોઈએ' => 'Should be confident']],
                    ['text_gu' => '11. આચાર્ય તમારી સાથે કૌટુંબિક સંબંધો ધરાવે છે ?', 'text_en' => 'Principal has family relation with you?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કેવા પ્રસંગોમાં ?', 'text_en' => 'If yes, in what occasions?', 'type' => 'text'],
                ]
            ],
            // Section 6
            [
                'title_gu' => 'વિભાગ – 6: વૈવાહિક ભૂમિકા અને ભૂમિક સંઘર્ષ',
                'title_en' => 'Section 6: Marital Role and Conflict',
                'questions' => [
                    ['text_gu' => '1. તમે શિક્ષિકા અને ગૃહિણી તરીકેની બેવડી ભૂમિકા ભજવો છો ?', 'text_en' => 'Double role of teacher and housewife?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '2. તમારી બેવડી ભૂમિકાને કારણે ભૂમિક સંઘર્ષનો અનુભવ કરો છો ?', 'text_en' => 'Experience role conflict?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '3. તમારો શિક્ષિકા નો વ્યવસાય તમને ઘરની સંભાળ રાખવામાં બાધક બને છે ?', 'text_en' => 'Job obstructs taking care of home?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કઈ રીતે ?', 'text_en' => 'If yes, how?', 'type' => 'text'],
                    ['text_gu' => '4. નોકરીના કારણે તમારે તમારા પતિ સાથે ઝઘડો થાય છે ?', 'text_en' => 'Conflict with husband due to job?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No', 'અપરિણીત' => 'Unmarried']],
                    ['text_gu' => 'જો હા, તો કેવા પ્રકારના ?', 'text_en' => 'If yes, what type?', 'type' => 'text'],
                    ['text_gu' => '5. નોકરીના કારણે તમે તમારા બાળક માટે એક આદર્શ ‘મા’ તરીકેની ભૂમિકા ભજવી શકો છો ?', 'text_en' => 'Play role of ideal mother?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો ના, તો શા માટે ?', 'text_en' => 'If no, why?', 'type' => 'text'],
                    ['text_gu' => '6. શું નોકરી અને ઘર સંભાળવું તમને મુશ્કેલ લાગે છે ?', 'text_en' => 'Is managing both difficult?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '7. ઘરણી ગૃહિણીની જવાબદારી અને શિક્ષિકાની ભૂમિકા ભજવવામાં બાધક બને છે ?', 'text_en' => 'Housewife duty obstructs teacher role?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કઈ રીતે ?', 'text_en' => 'If yes, how?', 'type' => 'text'],
                    ['text_gu' => '8. બેવડી ભૂમિકાથી તમને શારીરિક અને માનસિક થાક અનુભવવો પડે છે ?', 'text_en' => 'Physical mental fatigue due to dual role?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '9. તમે તમારી માતા તરીકેની અને એક પત્ની તરીકેની ભૂમિકા ભજવવાથી સંતોષ છે ?', 'text_en' => 'Satisfied playing mother and wife role?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No', 'અપરિણીત' => 'Unmarried']],
                    ['text_gu' => '10. નોકરીના કારણે તમારે ઘરના અન્ય સભ્યો સાથે તકરાર કે અણબનાવ રહે છે ?', 'text_en' => 'Conflict with other family members?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કેવા પ્રકારના ?', 'text_en' => 'If yes, what type?', 'type' => 'text'],
                    ['text_gu' => '11. ભૂમિક સંઘર્ષ તમારા આરોગ્ય પર અસર કરે છે ?', 'text_en' => 'Role conflict affects health?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કઈ રીતે ?', 'text_en' => 'If yes, how?', 'type' => 'text'],
                ]
            ],
            // Section 7
            [
                'title_gu' => 'વિભાગ – 7: સામાજિક અને આર્થિક દરજ્જો',
                'title_en' => 'Section 7: Social and Economic Status',
                'questions' => [
                    ['text_gu' => '1. શિક્ષિકા તરીકેના વ્યવસાયને કારણે તમારા દરજ્જામાં પરિવર્તન આવ્યું છે ?', 'text_en' => 'Status changed due to profession?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો કયા ક્ષેત્રમાં ?', 'text_en' => 'If yes, in what area?', 'type' => 'text'],
                    ['text_gu' => '2. કુટુંબના અંગતના સામાજિક અને આર્થિક નિર્ણયોમાં તમારી ભાગીદારી કેટલી ?', 'text_en' => 'Participation in family decisions?', 'type' => 'radio', 'options' => ['ઓછી' => 'Less', 'વધારે' => 'High', 'સામાન્ય' => 'Normal', 'નહિવત' => 'Negligible']],
                    ['text_gu' => '3. શિક્ષિકા તરીકેની નોકરીથી સમાજમાં તમારું સામાજિક સ્થાન ઊંચું ગયું છે ?', 'text_en' => 'Social status increased?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '4. સમાજની અન્ય સ્ત્રીઓ કરતા તમારો દરજ્જો કેવો છે ?', 'text_en' => 'Status compared to other women?', 'type' => 'radio', 'options' => ['ઉચ્ચ' => 'Higher', 'નીચ' => 'Lower', 'સમાન' => 'Equal']],
                    ['text_gu' => '5. તમારા પતિશ્રી પ્રત્યે આદરનું તમે શું કરો છો ?', 'text_en' => 'Salary utilization regarding husband?', 'type' => 'radio', 'options' => ['તમારી પાસે રાખો છો' => 'Keep for yourself', 'કુટુંબના મુખ્ય સભ્યને આપો છો' => 'Give to main member', 'અન્ય' => 'Other']],
                    ['text_gu' => 'જો અન્ય, તો શું ?', 'text_en' => 'If other, specify:', 'type' => 'text'],
                    ['text_gu' => '6. ઘરનું બજેટ બનાવતી વખતે તમારો અભિપ્રાય લેવાય છે ?', 'text_en' => 'Is your opinion taken for house budget?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '7. તમારા પગારમાંથી થતી આવક તમે સ્વતંત્રપણે વાપરી શકો છો ?', 'text_en' => 'Can you freely use your income?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '8. આવકનું તમે રોકાણ કરો છો ?', 'text_en' => 'Do you invest your income?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => 'જો હા, તો શેમાં ?', 'text_en' => 'If yes, where?', 'type' => 'checkbox', 'options' => ['જમીન' => 'Land', 'વીમા' => 'Insurance', 'શેર' => 'Shares', 'સોનામાં' => 'Gold', 'ખેતીમાં' => 'Agriculture', 'અન્ય' => 'Other']],
                    ['text_gu' => '9. તમારા આર્થિક નિર્ણયોમાં તમને સંપૂર્ણ સ્વતંત્રતા છે ?', 'text_en' => 'Complete freedom in economic decisions?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                    ['text_gu' => '10. કુટુંબના અને સમાજના માણસો તમને માનની નજરથી જુએ છે ?', 'text_en' => 'Do family and society respect you?', 'type' => 'radio', 'options' => ['હા' => 'Yes', 'ના' => 'No']],
                ]
            ]
        ];

        $secOrder = 1;
        foreach ($data as $secData) {
            $section = Section::create([
                'title_gu' => $secData['title_gu'],
                'title_en' => $secData['title_en'],
                'order' => $secOrder++,
                'is_active' => true,
            ]);

            $qOrder = 1;
            foreach ($secData['questions'] as $qData) {
                $question = Question::create([
                    'section_id' => $section->id,
                    'question_text_gu' => $qData['text_gu'],
                    'question_text_en' => $qData['text_en'],
                    'type' => $qData['type'],
                    'is_required' => false,
                    'order' => $qOrder++,
                    'is_active' => true,
                    'meta_params' => $qData['meta'] ?? null,
                ]);

                if (isset($qData['options'])) {
                    $optOrder = 1;
                    foreach ($qData['options'] as $guOpt => $enOpt) {
                        Option::create([
                            'question_id' => $question->id,
                            'option_text_gu' => $guOpt,
                            'option_text_en' => $enOpt,
                            'order' => $optOrder++,
                        ]);
                    }
                }
            }
        }
    }
}
