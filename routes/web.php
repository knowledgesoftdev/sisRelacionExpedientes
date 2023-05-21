<?php

use App\Http\Livewire\CasoComponent;
use App\Http\Livewire\CasoDownloadComponent;
use App\Http\Livewire\FiscalComponent;
use App\Http\Livewire\JuzgadoComponent;
use App\Http\Livewire\ReporteCasoComponent;
use App\Http\Livewire\ReporteCasoIdComponent;
use App\Http\Livewire\ReporteExpedienteComponent;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('fiscales',FiscalComponent::class);
Route::get('casos',CasoComponent::class);
Route::get('expedientes_juzgado',JuzgadoComponent::class);
Route::get('reporte_casos',ReporteCasoComponent::class);
Route::get('download-pdf-casos',[CasoDownloadComponent::class,'exportarPDF']);
Route::get('download-pdf-expedientes',[ReporteExpedienteComponent::class,'exportarPDF']);
Route::get('download-pdf-casosxfiscal/{fiscal_id}',[ReporteCasoIdComponent::class,'exportarPDFxFiscal']);
