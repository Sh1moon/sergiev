<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\HonoraryCitizen;
use App\Models\CouncilDeputy;
use App\Models\AdministrationDepartment;
use App\Models\AdministrationInstitution;
use App\Models\AdministrationTerritory;
use App\Models\ReferenceSection;
use App\Models\DistrictPoliceEntry;
use App\Models\ManagementCompanyRow;
use App\Services\DistrictPoliceTextParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function index()
    {
        return view('staff.content.index');
    }

    // Honorary Citizens
    public function honoraryIndex()
    {
        $items = HonoraryCitizen::orderBy('category')->orderBy('sort_order')->get();
        return view('staff.content.honorary-index', compact('items'));
    }

    public function honoraryEdit(HonoraryCitizen $honorary = null)
    {
        $honorary = $honorary ?? new HonoraryCitizen();
        return view('staff.content.honorary-edit', compact('honorary'));
    }

    public function honoraryStore(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'person_name' => 'required|string|max:255',
            'person_info' => 'nullable|string',
            'awarded_by' => 'required|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        HonoraryCitizen::create($request->only('category', 'person_name', 'person_info', 'awarded_by', 'sort_order'));
        return redirect()->route('staff.content.honorary')->with('success', 'Запись добавлена');
    }

    public function honoraryUpdate(Request $request, HonoraryCitizen $honorary)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'person_name' => 'required|string|max:255',
            'person_info' => 'nullable|string',
            'awarded_by' => 'required|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $honorary->update($request->only('category', 'person_name', 'person_info', 'awarded_by', 'sort_order'));
        return redirect()->route('staff.content.honorary')->with('success', 'Запись обновлена');
    }

    public function honoraryDestroy(HonoraryCitizen $honorary)
    {
        $honorary->delete();
        return redirect()->route('staff.content.honorary')->with('success', 'Запись удалена');
    }

    // Council Deputies (with photo)
    public function councilIndex()
    {
        $items = CouncilDeputy::orderBy('sort_order')->get();
        return view('staff.content.council-index', compact('items'));
    }

    public function councilEdit(CouncilDeputy $council = null)
    {
        $council = $council ?? new CouncilDeputy();
        return view('staff.content.council-edit', compact('council'));
    }

    public function councilStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'info' => 'nullable|string',
            'contacts' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|max:5120',
        ]);
        $data = $request->only('name', 'info', 'contacts', 'sort_order');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('council-deputies', 'public');
        }
        CouncilDeputy::create($data);
        return redirect()->route('staff.content.council')->with('success', 'Депутат добавлен');
    }

    public function councilUpdate(Request $request, CouncilDeputy $council)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'info' => 'nullable|string',
            'contacts' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|max:5120',
        ]);
        $data = $request->only('name', 'info', 'contacts', 'sort_order');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        if ($request->hasFile('photo')) {
            if ($council->photo) Storage::disk('public')->delete($council->photo);
            $data['photo'] = $request->file('photo')->store('council-deputies', 'public');
        }
        if ($request->boolean('photo_remove') && $council->photo) {
            Storage::disk('public')->delete($council->photo);
            $data['photo'] = null;
        }
        $council->update($data);
        return redirect()->route('staff.content.council')->with('success', 'Депутат обновлён');
    }

    public function councilDestroy(CouncilDeputy $council)
    {
        if ($council->photo) Storage::disk('public')->delete($council->photo);
        $council->delete();
        return redirect()->route('staff.content.council')->with('success', 'Депутат удалён');
    }

    // Administration Departments
    public function departmentsIndex()
    {
        $items = AdministrationDepartment::orderBy('sort_order')->get();
        return view('staff.content.departments-index', compact('items'));
    }

    public function departmentsEdit(AdministrationDepartment $department = null)
    {
        $department = $department ?? new AdministrationDepartment();
        return view('staff.content.departments-edit', compact('department'));
    }

    public function departmentsStore(Request $request)
    {
        $request->validate([
            'management_name' => 'required|string|max:255',
            'head_text' => 'nullable|string|max:500',
            'schedule_text' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data = $request->only('management_name', 'head_text', 'schedule_text', 'body', 'sort_order');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        AdministrationDepartment::create($data);
        return redirect()->route('staff.content.departments')->with('success', 'Подразделение добавлено');
    }

    public function departmentsUpdate(Request $request, AdministrationDepartment $department)
    {
        $request->validate([
            'management_name' => 'required|string|max:255',
            'head_text' => 'nullable|string|max:500',
            'schedule_text' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data = $request->only('management_name', 'head_text', 'schedule_text', 'body', 'sort_order');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $department->update($data);
        return redirect()->route('staff.content.departments')->with('success', 'Подразделение обновлено');
    }

    public function departmentsDestroy(AdministrationDepartment $department)
    {
        $department->delete();
        return redirect()->route('staff.content.departments')->with('success', 'Подразделение удалено');
    }

    // Administration Institutions
    public function institutionsIndex()
    {
        $items = AdministrationInstitution::orderBy('sort_order')->get();
        return view('staff.content.institutions-index', compact('items'));
    }

    public function institutionsEdit(AdministrationInstitution $institution = null)
    {
        $institution = $institution ?? new AdministrationInstitution();
        return view('staff.content.institutions-edit', compact('institution'));
    }

    public function institutionsStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'leader' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:500',
            'phones' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data = $request->only('title', 'leader', 'address', 'phones', 'email', 'website', 'description', 'sort_order');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        AdministrationInstitution::create($data);
        return redirect()->route('staff.content.institutions')->with('success', 'Учреждение добавлено');
    }

    public function institutionsUpdate(Request $request, AdministrationInstitution $institution)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'leader' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:500',
            'phones' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data = $request->only('title', 'leader', 'address', 'phones', 'email', 'website', 'description', 'sort_order');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $institution->update($data);
        return redirect()->route('staff.content.institutions')->with('success', 'Учреждение обновлено');
    }

    public function institutionsDestroy(AdministrationInstitution $institution)
    {
        $institution->delete();
        return redirect()->route('staff.content.institutions')->with('success', 'Учреждение удалено');
    }

    // Administration Territories
    public function territoriesIndex()
    {
        $items = AdministrationTerritory::orderBy('sort_order')->get();
        return view('staff.content.territories-index', compact('items'));
    }

    public function territoriesEdit(AdministrationTerritory $territory = null)
    {
        $territory = $territory ?? new AdministrationTerritory();
        return view('staff.content.territories-edit', compact('territory'));
    }

    public function territoriesStore(Request $request)
    {
        $request->validate([
            'management' => 'required|string|max:255',
            'leader' => 'nullable|string|max:255',
            'contacts' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data = $request->only('management', 'leader', 'contacts', 'address', 'sort_order');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        AdministrationTerritory::create($data);
        return redirect()->route('staff.content.territories')->with('success', 'Запись добавлена');
    }

    public function territoriesUpdate(Request $request, AdministrationTerritory $territory)
    {
        $request->validate([
            'management' => 'required|string|max:255',
            'leader' => 'nullable|string|max:255',
            'contacts' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data = $request->only('management', 'leader', 'contacts', 'address', 'sort_order');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $territory->update($data);
        return redirect()->route('staff.content.territories')->with('success', 'Запись обновлена');
    }

    public function territoriesDestroy(AdministrationTerritory $territory)
    {
        $territory->delete();
        return redirect()->route('staff.content.territories')->with('success', 'Запись удалена');
    }

    // District police entries (structured editor)
    public function districtPoliceIndex()
    {
        $entries = DistrictPoliceEntry::orderBy('sort_order')->orderBy('id')->get();
        return view('staff.content.district-police-index', compact('entries'));
    }

    public function districtPoliceEdit(?DistrictPoliceEntry $entry = null)
    {
        $entry = $entry ?? new DistrictPoliceEntry();
        return view('staff.content.district-police-edit', compact('entry'));
    }

    public function districtPoliceStore(Request $request)
    {
        $request->validate([
            'admin_district' => 'nullable|string|max:500',
            'responsible' => 'nullable|string',
            'substitute' => 'nullable|string',
            'residential_sector' => 'nullable|string',
            'reception_days' => 'nullable|string',
            'leadership_reception_days' => 'nullable|string',
            'reception_place' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data = $request->only([
            'admin_district', 'responsible', 'substitute', 'residential_sector',
            'reception_days', 'leadership_reception_days', 'reception_place', 'sort_order',
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        DistrictPoliceEntry::create($data);
        return redirect()->route('staff.content.district-police.index')->with('success', 'Запись добавлена');
    }

    public function districtPoliceUpdate(Request $request, DistrictPoliceEntry $entry)
    {
        $request->validate([
            'admin_district' => 'nullable|string|max:500',
            'responsible' => 'nullable|string',
            'substitute' => 'nullable|string',
            'residential_sector' => 'nullable|string',
            'reception_days' => 'nullable|string',
            'leadership_reception_days' => 'nullable|string',
            'reception_place' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data = $request->only([
            'admin_district', 'responsible', 'substitute', 'residential_sector',
            'reception_days', 'leadership_reception_days', 'reception_place', 'sort_order',
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $entry->update($data);
        return redirect()->route('staff.content.district-police.index')->with('success', 'Запись обновлена');
    }

    public function districtPoliceDestroy(DistrictPoliceEntry $entry)
    {
        $entry->delete();
        return redirect()->route('staff.content.district-police.index')->with('success', 'Запись удалена');
    }

    /** Импорт участковых из файла. Сначала используется resources/data/district_police.txt (основной файл), затем database/seeders/data/district_police_raw.txt. */
    public function districtPoliceImport()
    {
        $path = resource_path('data/district_police.txt');
        if (!is_file($path)) {
            $path = database_path('seeders/data/district_police_raw.txt');
        }
        if (!is_file($path)) {
            return redirect()->route('staff.content.district-police.index')->with('error', 'Файл с текстом участковых не найден.');
        }

        $text = file_get_contents($path);
        $entries = DistrictPoliceTextParser::parse($text);
        if (empty($entries)) {
            return redirect()->route('staff.content.district-police.index')->with('error', 'Не удалось разобрать записи из файла. Проверьте формат текста.');
        }

        DistrictPoliceEntry::truncate();
        foreach ($entries as $index => $data) {
            DistrictPoliceEntry::create([
                'sort_order' => $index + 1,
                'admin_district' => $data['admin_district'] ?? null,
                'responsible' => $data['responsible'] ?? null,
                'substitute' => $data['substitute'] ?? null,
                'residential_sector' => $data['residential_sector'] ?? null,
                'reception_days' => $data['reception_days'] ?? null,
                'leadership_reception_days' => $data['leadership_reception_days'] ?? null,
                'reception_place' => $data['reception_place'] ?? null,
            ]);
        }

        return redirect()->route('staff.content.district-police.index')->with('success', 'Импортировано записей: ' . count($entries) . '. Текст из файла добавлен в редактор.');
    }

    // Reference sections (emergency only; district_police uses districtPoliceIndex)
    public function referenceEdit(string $slug)
    {
        if ($slug === 'district_police') {
            return redirect()->route('staff.content.district-police.index');
        }
        $section = ReferenceSection::firstOrCreate(['slug' => $slug], ['content' => '']);
        if ($slug === 'emergency_phones' && trim($section->content ?? '') === '') {
            $path = resource_path('data/emergency_phones.txt');
            if (File::exists($path)) {
                $section->content = File::get($path);
            }
        }
        $titles = [
            'district_police' => 'Отдел участковых по району',
            'emergency_phones' => 'Телефоны экстренных служб',
        ];
        return view('staff.content.reference-edit', compact('section', 'titles'));
    }

    public function referenceUpdate(Request $request, string $slug)
    {
        $section = ReferenceSection::firstOrCreate(['slug' => $slug], ['content' => '']);
        $section->update(['content' => $request->get('content', '')]);
        $titles = ['district_police' => 'Участковые', 'emergency_phones' => 'Экстренные службы'];
        return redirect()->route('staff.content.index')->with('success', 'Раздел «' . ($titles[$slug] ?? $slug) . '» обновлён');
    }

    // Management companies
    public function managementIndex()
    {
        $managing = ManagementCompanyRow::where('section', 'managing')->orderBy('sort_order')->orderBy('num')->get();
        $resource = ManagementCompanyRow::where('section', 'resource')->orderBy('sort_order')->orderBy('num')->get();
        return view('staff.content.management-index', compact('managing', 'resource'));
    }

    public function managementEdit(ManagementCompanyRow $row = null)
    {
        $row = $row ?? new ManagementCompanyRow();
        return view('staff.content.management-edit', compact('row'));
    }

    public function managementStore(Request $request)
    {
        $request->validate([
            'section' => 'required|in:managing,resource',
            'num' => 'required|string|max:10',
            'content' => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data = $request->only('section', 'num', 'content', 'sort_order');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        ManagementCompanyRow::create($data);
        return redirect()->route('staff.content.management')->with('success', 'Запись добавлена');
    }

    public function managementUpdate(Request $request, ManagementCompanyRow $row)
    {
        $request->validate([
            'section' => 'required|in:managing,resource',
            'num' => 'required|string|max:10',
            'content' => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);
        $data = $request->only('section', 'num', 'content', 'sort_order');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $row->update($data);
        return redirect()->route('staff.content.management')->with('success', 'Запись обновлена');
    }

    public function managementDestroy(ManagementCompanyRow $row)
    {
        $row->delete();
        return redirect()->route('staff.content.management')->with('success', 'Запись удалена');
    }
}
