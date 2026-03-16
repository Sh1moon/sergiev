<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnticorruptionController;
use App\Http\Controllers\AppealController;
use App\Http\Controllers\GardenersController;
use App\Http\Controllers\PlaceholderController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\Staff\ArticleController as StaffArticleController;
use App\Http\Controllers\Staff\AnticorruptionController as StaffAnticorruptionController;
use App\Http\Controllers\Staff\AppealController as StaffAppealController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\Staff\CarouselController;
use App\Http\Controllers\Staff\VacancyController as StaffVacancyController;
use App\Http\Controllers\Staff\AdministrationController as StaffAdministrationController;
use App\Http\Controllers\Staff\ContentController as StaffContentController;
use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\HonoraryCitizensController;
use App\Http\Controllers\CouncilDeputiesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VacancyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Публичные маршруты
Route::get('/', [HomeController::class, 'index'])->name('home');

// Новости и разделы статей (унифицированная система)
Route::get('/news', [ArticleController::class, 'index'])->name('news.index')->defaults('sectionSlug', 'news');
Route::get('/sections/{sectionSlug}', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/news/{article:slug}', [ArticleController::class, 'show'])->name('news.show');
Route::get('/sections/{sectionSlug}/{article:slug}', [ArticleController::class, 'showWithSection'])->name('articles.show');

// Госадмтехнадзор и Информация — разделы статей (как новости)
Route::get('/gosadmtechnadzor', [ArticleController::class, 'index'])->name('gosadmtechnadzor')->defaults('sectionSlug', 'gosadmtechnadzor');
Route::get('/gosadmtechnadzor/{article:slug}', [ArticleController::class, 'show'])->name('gosadmtechnadzor.show')->defaults('sectionSlug', 'gosadmtechnadzor');
Route::get('/information', [ArticleController::class, 'index'])->name('information')->defaults('sectionSlug', 'information');
Route::get('/information/{article:slug}', [ArticleController::class, 'show'])->name('information.show')->defaults('sectionSlug', 'information');

// Заглушки для пунктов меню (без контейнера не меняем шапку)
Route::get('/competition', PlaceholderController::class)->name('competition');
Route::get('/organizations', PlaceholderController::class)->name('organizations');
Route::get('/activities', PlaceholderController::class)->name('activities');
Route::get('/our-district', function () {
    return view('our-district');
})->name('our-district');
Route::get('/our-district/council', [CouncilDeputiesController::class, 'index'])->name('our-district.council');
Route::get('/history', function () {
    return view('history');
})->name('history');
Route::get('/official-symbols', function () {
    return view('official-symbols');
})->name('official-symbols');
Route::get('/honorary-citizens', [HonoraryCitizensController::class, 'index'])->name('honorary-citizens');
Route::get('/sights', PlaceholderController::class)->name('sights');
Route::get('/gardeners', [GardenersController::class, 'index'])->name('gardeners');
Route::get('/gardeners/{article:slug}', [ArticleController::class, 'show'])->name('gardeners.show')->defaults('sectionSlug', 'gardeners');
Route::get('/go-chs', [ArticleController::class, 'index'])->name('go-chs')->defaults('sectionSlug', 'go-chs');
Route::get('/go-chs/{article:slug}', [ArticleController::class, 'show'])->name('go-chs.show')->defaults('sectionSlug', 'go-chs');
Route::get('/work-results', PlaceholderController::class)->name('work-results');
Route::get('/administration', [AdministrationController::class, 'index'])->name('administration');
Route::get('/administration/head', function () {
    return redirect()->route('administration')->withFragment('glava');
})->name('administration.head');
Route::get('/administration/deputies', function () {
    return redirect()->route('administration')->withFragment('zamestiteli');
})->name('administration.deputies');
Route::get('/administration/departments', function () {
    return redirect()->route('administration')->withFragment('podrazdeleniya');
})->name('administration.departments');
Route::get('/administration/institutions', function () {
    return redirect()->route('administration')->withFragment('uchrezhdeniya');
})->name('administration.institutions');
Route::get('/administration/territories', function () {
    return redirect()->route('administration')->withFragment('territorii');
})->name('administration.territories');
Route::get('/administration/emergency', function () {
    return redirect()->route('administration')->withFragment('go-chs');
})->name('administration.emergency');
Route::get('/documents', [DocumentsController::class, 'index'])->name('documents');
Route::get('/documents/charter', function () {
    return redirect()->route('documents')->withFragment('charter');
})->name('documents.charter');
Route::get('/documents/investment', function () {
    return redirect()->route('documents')->withFragment('investment');
})->name('documents.investment');
Route::get('/documents/resolutions', function () {
    return redirect()->route('documents')->withFragment('resolutions');
})->name('documents.resolutions');
Route::get('/documents/anticorruption', function () {
    return redirect()->route('documents')->withFragment('anticorruption');
})->name('documents.anticorruption');
Route::get('/documents/regulatory', function () {
    return redirect()->route('documents')->withFragment('regulatory');
})->name('documents.regulatory');
Route::get('/documents/control', function () {
    return redirect()->route('documents')->withFragment('control');
})->name('documents.control');
Route::get('/documents/expertise', function () {
    return redirect()->route('documents')->withFragment('expertise');
})->name('documents.expertise');
Route::get('/finance', [FinanceController::class, 'index'])->name('finance');
$financeSectionSlugs = 'forecast|report|programs|programs-archive|social-partnership';
Route::get('/finance/{sectionSlug}/{article:slug}', [ArticleController::class, 'showWithSection'])->name('finance.article.show')->where('sectionSlug', $financeSectionSlugs);
Route::get('/finance/{sectionSlug}', [ArticleController::class, 'index'])->name('finance.section')->where('sectionSlug', $financeSectionSlugs);
Route::get('/finance/{article:slug}', [ArticleController::class, 'show'])->name('finance.show')->defaults('sectionSlug', 'finance');
Route::get('/ecology', function () {
    return view('ecology');
})->name('ecology');
Route::get('/ecology/contacts', function () {
    return redirect()->route('ecology')->withFragment('contacts');
})->name('ecology.contacts');
Route::get('/ecology/info', function () {
    return redirect()->route('ecology')->withFragment('general');
})->name('ecology.info');
Route::get('/ecology/separate-collection', function () {
    return redirect()->route('ecology')->withFragment('separate');
})->name('ecology.separate-collection');
Route::get('/ecology/construction-waste', function () {
    return redirect()->route('ecology')->withFragment('construction');
})->name('ecology.construction-waste');
Route::get('/appeals', [AppealController::class, 'index'])->name('appeals')->middleware('auth');
Route::post('/appeals', [AppealController::class, 'store'])->name('appeals.store')->middleware('auth');
Route::get('/appeals/attachment/{appeal}', [AppealController::class, 'attachment'])->name('appeals.attachment')->middleware('auth');
Route::get('/appeals/{appeal}/edit', [AppealController::class, 'edit'])->name('appeals.edit')->middleware('auth');
Route::put('/appeals/{appeal}', [AppealController::class, 'update'])->name('appeals.update')->middleware('auth');
Route::get('/appeals/{appeal}', [AppealController::class, 'show'])->name('appeals.show')->middleware('auth');
Route::get('/appeals/work', function () {
    return view('appeals.work');
})->name('appeals.work');
Route::get('/appeals/schedule', function () {
    return view('appeals.schedule');
})->name('appeals.schedule');
Route::get('/appeals/online', PlaceholderController::class)->name('appeals.online');
Route::get('/appeals/anticorruption', [AnticorruptionController::class, 'index'])->name('appeals.anticorruption')->middleware('auth');
Route::post('/appeals/anticorruption', [AnticorruptionController::class, 'store'])->name('appeals.anticorruption.store')->middleware('auth');
Route::get('/appeals/ank', function () {
    return view('appeals.ank');
})->name('appeals.ank');
Route::get('/reference', [ReferenceController::class, 'index'])->name('reference');
Route::get('/reference/{section}', [ReferenceController::class, 'redirectToSection'])->name('reference.section')->where('section', 'district-police|emergency|departments|sitemap|management-companies|vacancies');
Route::get('/vacancies/{vacancy:slug}', [VacancyController::class, 'show'])->name('vacancy.show');

// Маршруты аутентификации
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Маршруты для администратора
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
});

// Кабинет сотрудника и администратора (контент)
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('staff.articles.index');
    })->name('dashboard');
    Route::resource('articles', StaffArticleController::class);
    Route::delete('/articles/{article}/files/{file}', [StaffArticleController::class, 'destroyFile'])->name('articles.files.destroy');
    Route::get('/carousel', [CarouselController::class, 'index'])->name('carousel.index');
    Route::post('/carousel', [CarouselController::class, 'store'])->name('carousel.store');
    Route::get('/carousel/{slide}/edit', [CarouselController::class, 'edit'])->name('carousel.edit');
    Route::put('/carousel/{slide}', [CarouselController::class, 'update'])->name('carousel.update');
    Route::delete('/carousel/{slide}', [CarouselController::class, 'destroy'])->name('carousel.destroy');
    Route::get('/appeals', [StaffAppealController::class, 'index'])->name('appeals.index');
    Route::get('/appeals/{appeal}', [StaffAppealController::class, 'show'])->name('appeals.show');
    Route::post('/appeals/{appeal}/respond', [StaffAppealController::class, 'respond'])->name('appeals.respond');
    Route::get('/anticorruption', [StaffAnticorruptionController::class, 'index'])->name('anticorruption.index');
    Route::get('/anticorruption/{report}', [StaffAnticorruptionController::class, 'show'])->name('anticorruption.show');
    Route::post('/anticorruption/{report}/respond', [StaffAnticorruptionController::class, 'respond'])->name('anticorruption.respond');
    Route::resource('vacancies', StaffVacancyController::class)->except(['show']);
    Route::get('/administration', [StaffAdministrationController::class, 'index'])->name('administration.index');
    Route::get('/administration/head', [StaffAdministrationController::class, 'editHead'])->name('administration.editHead');
    Route::put('/administration/head', [StaffAdministrationController::class, 'updateHead'])->name('administration.updateHead');
    Route::get('/administration/deputies/create', [StaffAdministrationController::class, 'createDeputy'])->name('administration.createDeputy');
    Route::post('/administration/deputies', [StaffAdministrationController::class, 'storeDeputy'])->name('administration.storeDeputy');
    Route::get('/administration/deputies/{deputy}/edit', [StaffAdministrationController::class, 'editDeputy'])->name('administration.editDeputy');
    Route::put('/administration/deputies/{deputy}', [StaffAdministrationController::class, 'updateDeputy'])->name('administration.updateDeputy');
    Route::delete('/administration/deputies/{deputy}', [StaffAdministrationController::class, 'destroyDeputy'])->name('administration.destroyDeputy');

    Route::get('/content', [StaffContentController::class, 'index'])->name('content.index');
    Route::get('/content/honorary', [StaffContentController::class, 'honoraryIndex'])->name('content.honorary');
    Route::get('/content/honorary/create', [StaffContentController::class, 'honoraryEdit'])->name('content.honorary.create');
    Route::post('/content/honorary', [StaffContentController::class, 'honoraryStore'])->name('content.honorary.store');
    Route::get('/content/honorary/{honorary}/edit', [StaffContentController::class, 'honoraryEdit'])->name('content.honorary.edit');
    Route::put('/content/honorary/{honorary}', [StaffContentController::class, 'honoraryUpdate'])->name('content.honorary.update');
    Route::delete('/content/honorary/{honorary}', [StaffContentController::class, 'honoraryDestroy'])->name('content.honorary.destroy');

    Route::get('/content/council', [StaffContentController::class, 'councilIndex'])->name('content.council');
    Route::get('/content/council/create', [StaffContentController::class, 'councilEdit'])->name('content.council.create');
    Route::post('/content/council', [StaffContentController::class, 'councilStore'])->name('content.council.store');
    Route::get('/content/council/{council}/edit', [StaffContentController::class, 'councilEdit'])->name('content.council.edit');
    Route::put('/content/council/{council}', [StaffContentController::class, 'councilUpdate'])->name('content.council.update');
    Route::delete('/content/council/{council}', [StaffContentController::class, 'councilDestroy'])->name('content.council.destroy');

    Route::get('/content/departments', [StaffContentController::class, 'departmentsIndex'])->name('content.departments');
    Route::get('/content/departments/create', [StaffContentController::class, 'departmentsEdit'])->name('content.departments.create');
    Route::post('/content/departments', [StaffContentController::class, 'departmentsStore'])->name('content.departments.store');
    Route::get('/content/departments/{department}/edit', [StaffContentController::class, 'departmentsEdit'])->name('content.departments.edit');
    Route::put('/content/departments/{department}', [StaffContentController::class, 'departmentsUpdate'])->name('content.departments.update');
    Route::delete('/content/departments/{department}', [StaffContentController::class, 'departmentsDestroy'])->name('content.departments.destroy');

    Route::get('/content/institutions', [StaffContentController::class, 'institutionsIndex'])->name('content.institutions');
    Route::get('/content/institutions/create', [StaffContentController::class, 'institutionsEdit'])->name('content.institutions.create');
    Route::post('/content/institutions', [StaffContentController::class, 'institutionsStore'])->name('content.institutions.store');
    Route::get('/content/institutions/{institution}/edit', [StaffContentController::class, 'institutionsEdit'])->name('content.institutions.edit');
    Route::put('/content/institutions/{institution}', [StaffContentController::class, 'institutionsUpdate'])->name('content.institutions.update');
    Route::delete('/content/institutions/{institution}', [StaffContentController::class, 'institutionsDestroy'])->name('content.institutions.destroy');

    Route::get('/content/territories', [StaffContentController::class, 'territoriesIndex'])->name('content.territories');
    Route::get('/content/territories/create', [StaffContentController::class, 'territoriesEdit'])->name('content.territories.create');
    Route::post('/content/territories', [StaffContentController::class, 'territoriesStore'])->name('content.territories.store');
    Route::get('/content/territories/{territory}/edit', [StaffContentController::class, 'territoriesEdit'])->name('content.territories.edit');
    Route::put('/content/territories/{territory}', [StaffContentController::class, 'territoriesUpdate'])->name('content.territories.update');
    Route::delete('/content/territories/{territory}', [StaffContentController::class, 'territoriesDestroy'])->name('content.territories.destroy');

    Route::get('/content/district-police', [StaffContentController::class, 'districtPoliceIndex'])->name('content.district-police.index');
    Route::post('/content/district-police/import', [StaffContentController::class, 'districtPoliceImport'])->name('content.district-police.import');
    Route::get('/content/district-police/create', [StaffContentController::class, 'districtPoliceEdit'])->name('content.district-police.create');
    Route::post('/content/district-police', [StaffContentController::class, 'districtPoliceStore'])->name('content.district-police.store');
    Route::get('/content/district-police/{entry}/edit', [StaffContentController::class, 'districtPoliceEdit'])->name('content.district-police.edit');
    Route::put('/content/district-police/{entry}', [StaffContentController::class, 'districtPoliceUpdate'])->name('content.district-police.update');
    Route::delete('/content/district-police/{entry}', [StaffContentController::class, 'districtPoliceDestroy'])->name('content.district-police.destroy');

    Route::get('/content/reference/{slug}', [StaffContentController::class, 'referenceEdit'])->name('content.reference.edit')->where('slug', 'district_police|emergency_phones');
    Route::put('/content/reference/{slug}', [StaffContentController::class, 'referenceUpdate'])->name('content.reference.update')->where('slug', 'district_police|emergency_phones');

    Route::get('/content/management', [StaffContentController::class, 'managementIndex'])->name('content.management');
    Route::get('/content/management/create', [StaffContentController::class, 'managementEdit'])->name('content.management.create');
    Route::post('/content/management', [StaffContentController::class, 'managementStore'])->name('content.management.store');
    Route::get('/content/management/{row}/edit', [StaffContentController::class, 'managementEdit'])->name('content.management.edit');
    Route::put('/content/management/{row}', [StaffContentController::class, 'managementUpdate'])->name('content.management.update');
    Route::delete('/content/management/{row}', [StaffContentController::class, 'managementDestroy'])->name('content.management.destroy');
});

// Устаревший префикс employee — редирект в кабинет
Route::middleware(['auth', 'role:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('staff.articles.index');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});
