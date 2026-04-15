<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = User::create([
            'name' => 'Админ',
            'email' => 'admin@odod.mn',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Categories
        $categories = [
            ['name' => 'Улс төр', 'name_en' => 'Politics', 'slug' => 'politics', 'color' => '#EF4444', 'sort_order' => 1],
            ['name' => 'Эдийн засаг', 'name_en' => 'Economy', 'slug' => 'economy', 'color' => '#F59E0B', 'sort_order' => 2],
            ['name' => 'Нийгэм', 'name_en' => 'Society', 'slug' => 'society', 'color' => '#3B82F6', 'sort_order' => 3],
            ['name' => 'Спорт', 'name_en' => 'Sports', 'slug' => 'sports', 'color' => '#10B981', 'sort_order' => 4],
            ['name' => 'Технологи', 'name_en' => 'Technology', 'slug' => 'technology', 'color' => '#8B5CF6', 'sort_order' => 5],
            ['name' => 'Соёл урлаг', 'name_en' => 'Culture', 'slug' => 'culture', 'color' => '#EC4899', 'sort_order' => 6],
            ['name' => 'Боловсрол', 'name_en' => 'Education', 'slug' => 'education', 'color' => '#06B6D4', 'sort_order' => 7],
            ['name' => 'Эрүүл мэнд', 'name_en' => 'Health', 'slug' => 'health', 'color' => '#14B8A6', 'sort_order' => 8],
            ['name' => 'Дэлхий', 'name_en' => 'World', 'slug' => 'world', 'color' => '#6366F1', 'sort_order' => 9],
            ['name' => 'Видео', 'name_en' => 'Video', 'slug' => 'video', 'color' => '#F43F5E', 'sort_order' => 10],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Tags
        $tagNames = [
            'Монгол Улс', 'УИХ', 'Засгийн газар', 'Эдийн засаг', 'Бизнес',
            'Уул уурхай', 'Боловсрол', 'Эрүүл мэнд', 'Хөрөнгө оруулалт', 'Технологи',
            'Startup', 'AI', 'Спорт', 'Хөл бөмбөг', 'Бөх',
        ];

        foreach ($tagNames as $name) {
            Tag::create(['name' => $name]);
        }

        // Authors
        $authors = [
            ['name' => 'Б. Болормаа', 'email' => 'bolormaa@odod.mn', 'position' => 'Ахлах сэтгүүлч', 'bio' => 'Улс төрийн мэдээний ахлах сэтгүүлч, 10 жилийн туршлагатай.', 'user_id' => $admin->id],
            ['name' => 'Д. Ганбаатар', 'email' => 'ganbaatar@odod.mn', 'position' => 'Спорт сэтгүүлч', 'bio' => 'Монголын спортын мэдээний мэргэжилтэн.'],
            ['name' => 'С. Сарантуяа', 'email' => 'sarantuya@odod.mn', 'position' => 'Технологи сэтгүүлч', 'bio' => 'Технологи, инновацийн чиглэлийн сэтгүүлч.'],
            ['name' => 'Т. Тэмүүлэн', 'email' => 'temuulen@odod.mn', 'position' => 'Эдийн засаг сэтгүүлч', 'bio' => 'Эдийн засаг, санхүүгийн мэдээний шинжээч.'],
        ];

        $authorModels = [];
        foreach ($authors as $author) {
            $authorModels[] = Author::create($author);
        }

        // Articles
        $articles = [
            [
                'title' => 'Монгол Улсын эдийн засаг 2026 онд 6.2 хувиар өсөх төлөвтэй',
                'excerpt' => 'Дэлхийн банкны урьдчилсан тооцоогоор Монгол Улсын эдийн засаг энэ онд 6.2 хувиар өсөх төлөвтэй байна.',
                'body' => '<p>Дэлхийн банкны шинэчилсэн тооцоогоор Монгол Улсын ДНБ 2026 онд 6.2 хувиар өсөх төлөвтэй байна. Энэ нь өмнөх оны 5.8 хувийн өсөлтөөс дээгүүр үзүүлэлт юм.</p><p>Уул уурхайн экспорт нэмэгдсэн, дотоодын хэрэглээ сэргэсэн зэрэг хүчин зүйлс эдийн засгийн өсөлтөд эерэгээр нөлөөлж байна.</p>',
                'category_id' => 2, 'author_id' => 4, 'status' => 'published', 'is_featured' => true, 'is_trending' => true,
                'views_count' => 15420, 'published_at' => now()->subHours(2),
            ],
            [
                'title' => 'УИХ-ын намрын чуулган эхэллээ',
                'excerpt' => 'Улсын Их Хурлын 2026 оны намрын ээлжит чуулган өнөөдөр нээлтээ хийлээ.',
                'body' => '<p>Улсын Их Хурлын 2026 оны намрын ээлжит чуулган өнөөдөр нээлтээ хийв. Чуулганаар төсвийн тухай хууль, нийгмийн даатгалын шинэчлэл зэрэг чухал асуудлуудыг хэлэлцэх юм байна.</p>',
                'category_id' => 1, 'author_id' => 1, 'status' => 'published', 'is_featured' => true, 'is_breaking' => true,
                'views_count' => 23100, 'published_at' => now()->subHours(1),
            ],
            [
                'title' => 'Монголын стартап экосистем хурдацтай хөгжиж байна',
                'excerpt' => '"Startup Mongolia" хөтөлбөрийн хүрээнд 50 гаруй шинэ стартап компани байгуулагдлаа.',
                'body' => '<p>Сүүлийн нэг жилд Монголын стартап экосистем мэдэгдэхүйц хөгжил гарган ажиллаж байна. "Startup Mongolia" хөтөлбөрийн дэмжлэгтэйгээр 50 гаруй стартап шинээр байгуулагдлаа.</p>',
                'category_id' => 5, 'author_id' => 3, 'status' => 'published', 'is_featured' => true, 'is_trending' => true,
                'views_count' => 8930, 'published_at' => now()->subHours(4),
            ],
            [
                'title' => 'Монголын боксчин олимпийн алтан медаль хүртлээ',
                'excerpt' => 'Монголын боксын тамирчин олон улсын тэмцээнд алтан медаль хүртэж, түүхэн амжилт тогтоолоо.',
                'body' => '<p>Монголын боксын тамирчин Н. Баатарсүх олон улсын боксын аварга шалгаруулах тэмцээнд алтан медаль хүртлээ.</p>',
                'category_id' => 4, 'author_id' => 2, 'status' => 'published', 'is_featured' => true, 'is_trending' => true,
                'views_count' => 31200, 'published_at' => now()->subHours(6),
            ],
            [
                'title' => 'Улаанбаатарт шинэ метроны барилга эхэллээ',
                'excerpt' => 'Улаанбаатар хотын метроны анхны шугамын барилга ажил албан ёсоор эхэлж байна.',
                'body' => '<p>Улаанбаатар хотын олон жилийн мөрөөдөл болсон метроны анхны шугамын барилга ажил албан ёсоор эхэлж байна. Метроны анхны шугам 18 км урттай, 14 буудалтай байх юм.</p>',
                'category_id' => 3, 'author_id' => 1, 'status' => 'published', 'is_trending' => true,
                'views_count' => 19500, 'published_at' => now()->subHours(8),
            ],
            [
                'title' => 'AI технологи Монголын боловсролд нэвтэрч байна',
                'excerpt' => 'Хиймэл оюун ухаан ашигласан сургалтын платформууд Монголын их дээд сургуулиудад нэвтэрч эхэллээ.',
                'body' => '<p>Монголын их дээд сургуулиудад хиймэл оюун ухаан дээр суурилсан сургалтын платформууд нэвтэрч эхэллээ.</p>',
                'category_id' => 7, 'author_id' => 3, 'status' => 'published',
                'views_count' => 6700, 'published_at' => now()->subHours(10),
            ],
            [
                'title' => 'Монголын аялал жуулчлал рекорд тогтоолоо',
                'excerpt' => '2026 оны эхний хагас жилд Монголд 500,000 гаруй жуулчин зочилсон байна.',
                'body' => '<p>2026 оны эхний хагас жилд Монголд 500,000 гаруй гадаадын жуулчин зочилж, рекорд тогтоожээ.</p>',
                'category_id' => 3, 'author_id' => 4, 'status' => 'published', 'is_featured' => true,
                'views_count' => 12300, 'published_at' => now()->subHours(12),
            ],
            [
                'title' => 'Зэсийн үнэ дэлхийн зах зээл дээр өсчээ',
                'excerpt' => 'Дэлхийн зах зээл дээр зэсийн үнэ тонн нь 10,000 ам.доллар давлаа.',
                'body' => '<p>Дэлхийн зах зээл дээр зэсийн үнэ тонн нь 10,000 ам.доллар давж, сүүлийн 2 жилийн дээд түвшинд хүрлээ.</p>',
                'category_id' => 2, 'author_id' => 4, 'status' => 'published', 'is_trending' => true,
                'views_count' => 9800, 'published_at' => now()->subHours(14),
            ],
            [
                'title' => 'Монголын кино Каннын наадамд оролцоно',
                'excerpt' => 'Монголын найруулагч Б.Баясгалангийн шинэ кино Каннын олон улсын кино наадмын хөтөлбөрт багтлаа.',
                'body' => '<p>Монголын найруулагч Б.Баясгалангийн "Мөнх тэнгэр" кино Каннын олон улсын кино наадмын албан ёсны хөтөлбөрт сонгогдлоо.</p>',
                'category_id' => 6, 'author_id' => 1, 'status' => 'published',
                'views_count' => 7200, 'published_at' => now()->subHours(16),
            ],
            [
                'title' => 'Эрүүл мэндийн шинэ даатгалын тогтолцоо нэвтэрнэ',
                'excerpt' => '2026 оноос эхлэн эрүүл мэндийн даатгалын шинэ тогтолцоо хэрэгжиж эхэлнэ.',
                'body' => '<p>Засгийн газраас эрүүл мэндийн даатгалын шинэ тогтолцоог 2026 оноос эхлэн нэвтрүүлэхээр болсон.</p>',
                'category_id' => 8, 'author_id' => 1, 'status' => 'published',
                'views_count' => 5400, 'published_at' => now()->subHours(18),
            ],
            [
                'title' => 'Дэлхийн цаг уурын өөрчлөлтийн бага хурал эхэллээ',
                'excerpt' => 'НҮБ-ын цаг уурын өөрчлөлтийн бага хурал энэ долоо хоногт эхэлж байна.',
                'body' => '<p>НҮБ-ын цаг уурын өөрчлөлтийн талаарх дараагийн бага хурал Женевт эхэлж байна.</p>',
                'category_id' => 9, 'author_id' => 4, 'status' => 'published',
                'views_count' => 4100, 'published_at' => now()->subHours(20),
            ],
            [
                'title' => 'Монголын сагсан бөмбөгийн шигшээ баг Азийн аваргад оролцоно',
                'excerpt' => 'Монголын сагсан бөмбөгийн эрэгтэй шигшээ баг Азийн аварга шалгаруулах тэмцээнд бэлтгэж байна.',
                'body' => '<p>Монголын сагсан бөмбөгийн эрэгтэй шигшээ баг ирэх сарын Азийн аварга шалгаруулах тэмцээнд бэлтгэж байна.</p>',
                'category_id' => 4, 'author_id' => 2, 'status' => 'published',
                'views_count' => 8500, 'published_at' => now()->subHours(22),
            ],
        ];

        $tags = Tag::all();

        foreach ($articles as $articleData) {
            $article = Article::create($articleData);
            $article->tags()->attach($tags->random(rand(2, 4))->pluck('id'));
        }
    }
}
