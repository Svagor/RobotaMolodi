<?php


use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vacancy;
use \App\Models\Company;
use \App\Models\Resume;
use \App\Models\City;
use \App\Models\Industry;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
        $this->call('VacancySeeder');
        $this->call('CompanySeeder');
		//$this->call('UserTableSeeder');
        $this->call('ResumeSeeder'); // Заповнення таблиці resumes даними
        $this->call('CitySeeder');
        $this->call('IndustrySeeder');
	}

}


class VacancySeeder extends Seeder
{
    public function Run()
    {
        $id = '3';
        $branch = "sasas";
        $organisation = "org2";

        DB::table('vacancies')->delete();
        Vacancy::create([
            "company_id" => $id,
            "branch"    => $branch,
            "organisation"=> $organisation,
            "date_field"=>"12.01.123",
            "salary"=>"3000",
            "city"=>"Vinnytsa",
            "description"=>"bla-bla-bla"]);
    }

}

class CompanySeeder extends Seeder
{
    public function run()
    {
        $company_id = '2';
        $company_name = "Sasha";
        $company_email = "1989alpan@gmail.com";
        //DB::table("company")->delete();
        Company::create([
            "company_id" => $company_id,
            "company_name" =>$company_name,
            "company_email" => $company_email
        ]);
    }

}

class ResumeSeeder extends Seeder  // Заповнення таблиці resumes даними
{
    public function run()
    {
        DB::table('resumes')->delete();
        Resume::create([
            'name_u'=> 'Сергій Коломієць',
            'telephone'=> '0963363495',
            'email'=> '3sorey4@gmail.com',
            'position'=> 'Розробник програмного забезпечення',
            'industry'=> 'Ювелірна' ,
            'city'=> 'Вінниця',
            'salary'=> 20100,
            'description'=> 'Створення програмного забезпечення для штампу на дорогоцінних металах.',
        ]);

        Resume::create([
            'name_u'=> 'Сергій Коломієць',
            'telephone'=> '0963363495',
            'email'=> '3sorey4@gmail.com',
            'position'=> 'Програміст С++',
            'industry'=> 'Харчова' ,
            'city'=> 'Вінниця',
            'salary'=> 20300,
            'description'=> 'Створення програмного забезпечення для конвеєрного виробництва.',
        ]);

        Resume::create([
            'name_u'=> 'Сергій Коломієць',
            'telephone'=> '0963363495',
            'email'=> '3sorey4@gmail.com',
            'position'=> 'Програміст С#',
            'industry'=> 'Шкіряна' ,
            'city'=> 'Вінниця',
            'salary'=> 20500,
            'description'=> 'Створення програми для обчислення розмірів тканин.',
        ]);

    }
}

class CitySeeder extends Seeder
{
   /* $cities = array("Винница", "Днепропетровск", "Донецк", "Житомир", "Запорожье",
                    "Ивано-Франковск", "Киев", "Кировоград", "Луганск", "Луцк",
                    "Львов", "Николаев", "Одесса", "Полтава", "Ровно", "Севастополь",
                   "Симферополь", "Сумы", "Тернополь", "Ужгород", "Харьков", "Херсон",
                   "Хмельницкий", "Черкассы", "Чернигов");
   */

    public function run()
    {
        DB::table("cities")->delete();
        City::create(["name" => "Вінниця"]);
        City::create(["name" => "Дніпропетровськ"]);
        City::create(["name" => "Донецьк"]);
        City::create(["name" => "Житомир"]);
        City::create(["name" => "Запоріжжя"]);
        City::create(["name" => "Івано-Франківськ"]);
        City::create(["name" => "Київ"]);
        City::create(["name" => "Кіровоград"]);
        City::create(["name" => "Луганськ"]);
        City::create(["name" => "Луцьк"]);
        City::create(["name" => "Львів"]);
        City::create(["name" => "Миколаїв"]);
        City::create(["name" => "Одеса"]);
        City::create(["name" => "Полтава"]);
        City::create(["name" => "Рівне"]);
        City::create(["name" => "Севастополь"]);
        City::create(["name" => "Сімферополь"]);
        City::create(["name" => "Суми"]);
        City::create(["name" => "Тернопіль"]);
        City::create(["name" => "Ужгород"]);
        City::create(["name" => "Харків"]);
        City::create(["name" => "Херсон"]);
        City::create(["name" => "Хмельницький"]);
        City::create(["name" => "Черкаси"]);
        City::create(["name" => "Чернігів"]);
        City::create(["name" => "Чернівці"]);
    }
}
class IndustrySeeder extends Seeder
{
    public function run()
    {
        DB::table("industries")->delete();
        Industry::create(["name" => "Торгівля/продаж"]);
        Industry::create(["name" => "Інформаційні технології"]);
        Industry::create(["name" => "Керівництво/топ-менеджмент"]);
        Industry::create(["name" => "Менеджери/керівники середньої ланки"]);
        Industry::create(["name" => "Бухгалтерія/банк/фінанси/аудит"]);
        Industry::create(["name" => "Офісний персонал/HR"]);
        Industry::create(["name" => "Реклама/маркетинг/pr"]);
        Industry::create(["name" => "Інженерія/технології"]);
        Industry::create(["name" => "Будівництво/архітектура/нерухомість"]);
        Industry::create(["name" => "Юриспруденція/страхування/консалтинг"]);
        Industry::create(["name" => "Логістика/склад/митниця"]);
        Industry::create(["name" => "Транспорт/служба безпеки/охорона"]);
        Industry::create(["name" => "Поліграфія/дизайн/оформлення"]);
        Industry::create(["name" => "Виробництво/робітничі спеціальності"]);
        Industry::create(["name" => "Краса/фітнес/спорт/туризм"]);
        Industry::create(["name" => "Мистецтво/розваги/шоу-бізнес"]);
        Industry::create(["name" => "Журналістика/редагування/переклади"]);
        Industry::create(["name" => "Освіта/наука/виховання"]);
        Industry::create(["name" => "Сфера обслуговування/кулінарія/готелі/ресторани"]);
        Industry::create(["name" => "Охорона здоров'я/фармацевтика"]);
        Industry::create(["name" => "Cільське господарство/переробка с/г продукції"]);
        Industry::create(["name" => "Домашній персонал/різноробочі"]);
        Industry::create(["name" => "Громадські організації/політичні партії"]);
        Industry::create(["name" => "Екологія/охорона навколишнього середовища"]);
        Industry::create(["name" => "Соціальна сфера"]);
    }

}