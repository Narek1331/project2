<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SiteRequest;
use App\Services\{
    SiteService,
    SiteKeywordService,
    AdminParamService
};
use App\Imports\SitesImport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class SiteController extends Controller
{
    public function __construct(
        protected SiteService $siteService,
        protected SiteKeywordService $keywordService,
        protected AdminParamService $adminParamService
    ) {}

    public function index(): View
    {
        $adminParam = $this->adminParamService->get();
        $sites = $this->siteService->getAllByUser(auth()->id());

        return view('admin.site.index', compact('sites', 'adminParam'));
    }

    public function create(): View
    {
        return view('admin.site.create');
    }

    public function edit(int $id): View
    {
        $site = $this->siteService->getById($id);

        return view('admin.site.edit', compact('site'));
    }

    public function store(SiteRequest $request): RedirectResponse
    {

        $site = $this->siteService->store(
            auth()->id(),
            $request->input('domain'),
            $request->input('region'),
            $request->input('city')
        );

        if (!$site) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['domain' => 'Домен уже существует.']);
        }

        $keywords = $request->input('keywords', []);
        if (is_array($keywords)) {
            foreach ($keywords as $keywordData) {
                $this->keywordService->store(
                    $site->id,
                    $keywordData['name'] ?? '',
                    $keywordData['url'] ?? null,
                    (int)($keywordData['clicks_per_day'] ?? 0)
                );
            }
        }

        return redirect()
            ->route('admin.site')
            ->with('success', 'Сайт и ключевые слова успешно добавлены.');
    }

    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        Excel::import(new SitesImport, $request->file('file'));

        return redirect()
            ->route('admin.site')
            ->with('success', 'Импорт сайтов и ключевых слов выполнен успешно.');
    }

    public function updateStatus(int $id, Request $request): RedirectResponse
    {

        if (!$this->siteService->updateStatus($id)) {
            return redirect()
                ->back()
                ->withErrors(['status' => 'Не удалось обновить статус сайта.']);
        }

        return redirect()
            ->route('admin.site')
            ->with('success', 'Статус сайта успешно обновлён.');
    }

    public function update(int $id, SiteRequest $request): RedirectResponse
    {

        $this->siteService->update($id, $request->all());

        return redirect()
            ->back()
            ->with('success', 'Сайт успешно обновлён.');
    }

    public function delete(int $id): RedirectResponse
    {
        try {
            $site = $this->siteService->getById($id);

            if ($site) {
                $site->delete();

                return redirect()
                    ->back()
                    ->with('success', 'Сайт успешно удалён.');
            }

            return redirect()
                ->back()
                ->withErrors(['site' => 'Сайт не найден.']);
        } catch (\Throwable $e) {

            return redirect()
                ->back()
                ->withErrors(['site' => 'Произошла ошибка при удалении сайта.']);
        }
    }
}
