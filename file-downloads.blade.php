Livewire supports triggering file downloads for users with a simple, intuitive API.

To trigger a file download, you can return a Laravel file download from any component action.

@component('components.code-component')
@slot('class')
@verbatim
class ExportButton extends Component
{
    public function export()
    {
        return Storage::disk('exports')->download('export.csv');
    }
}
@endverbatim
@endslot
@slot('view')
@verbatim
<button wire:click="export">
    Download File
</button>
@endverbatim
@endslot
@endcomponent

Livewire should handle any file download that Laravel would. Here are a few other utilities you might use:

@component('components.code', ['lang' => 'php'])
@verbatim
return response()->download(storage_path('exports/export.csv'));
@endverbatim
@endcomponent

@component('components.code', ['lang' => 'php'])
@verbatim
return response()->streamDownload(function () {
    echo 'CSV Contents...';
}, 'export.csv');
@endverbatim
@endcomponent

## Testing File Downloads
Testing file downloads is simple with livewire.

Here is an example of testing the component above and making sure the export was downloaded.

@component('components.code-component', [
    'className' => 'ExportDownloadedTest.php',
])
@slot('class')
@verbatim
/** @test */
public function can_download_export()
{
    Livewire::test(ExportButton::class)
        ->call('download')
        ->assertFileDownloaded('export')
    ;

}
@endverbatim
@endslot
@endcomponent