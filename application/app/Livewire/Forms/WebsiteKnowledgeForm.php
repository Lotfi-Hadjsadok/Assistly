<?php

namespace App\Livewire\Forms;

use App\Models\Embedding;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;
use App\Models\KnowledgeWebsite;
use Livewire\Attributes\Validate;

class WebsiteKnowledgeForm extends Form
{
    public $url = '';
    public $title = '';
    public $description = '';
    public $newPage = '';

    public function addWebsite()
    {
        $this->validate([
            'url' => [
                'required',
                'regex:/^([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,}(\/[\w\-\/]*)?$/i',
                'unique:knowledge_websites,url',
            ],
        ]);

        $this->url = "https://{$this->url}";


        Auth::user()->websites()->create(
            [
                'url' => $this->url
            ]
        );

        $this->reset(['url']);
        Flux::modal('add-website')->close();
    }

    public function deleteWebsite(KnowledgeWebsite $website)
    {
        if ($website) {
            $website->embeddings()?->delete();
            $website->delete();

            Flux::toast(
                text: 'Website deleted successfully',
                variant: 'success'
            );
        }
    }


    public function addToSiteMap(KnowledgeWebsite $website)
    {
        $this->validate([
            'newPage' => [
                'required',
                'regex:/^\/[\w\-\/]*$/',
            ],
        ]);

        $newPage = parse_url($website->url);
        $newPage = $newPage['scheme'] . '://' . $newPage['host'] . $this->newPage;
        $sitemaps = $website->sitemap ?? [];
        $sitemaps[] = [
            'url' => $newPage,
            'trained' => false,
        ];
        $website->sitemap = $sitemaps;
        $website->save();
        $this->reset(['newPage']);
    }

    public function removeFromSiteMap(KnowledgeWebsite $website, $page)
    {
        $website->sitemap = array_filter($website->sitemap, function ($item) use ($page) {
            return $item['url'] !== $page;
        });
        Embedding::where('metadata->source', $page)->delete();
        $website->save();
    }
    public function resetForm()
    {
        $this->reset(['url']);
    }

    public function trainWebsite(KnowledgeWebsite $website)
    {
        $website->train();
    }
}
