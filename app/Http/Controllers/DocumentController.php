<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\Settings;

class DocumentController extends Controller
{
    //
    public function convertWordToPDF()
    {
        /* Set the PDF Engine Renderer Path */
        $domPdfPath = base_path('vendor/dompdf/dompdf');

        Settings::setPdfRendererPath($domPdfPath);
        Settings::setPdfRendererName('DomPDF');

        /*@ Reading doc file */
        $template = new \PhpOffice\PhpWord\TemplateProcessor(public_path('result.docx'));

        /*@ Replacing variables in doc file */
        $template->setValue('date', date('d-m-Y'));
        $template->setValue('title', 'Mr.');
        $template->setValue('firstname', 'Josue');
        $template->setValue('lastname', 'Lopez');

        /*@ Save Temporary Word File With New Name */
        $saveDocPath = public_path('new-result.docx');
        $template->saveAs($saveDocPath);

        // Load temporarily create word file
        $Content = \PhpOffice\PhpWord\IOFactory::load($saveDocPath);

        //Save it into PDF
        $savePdfPath = public_path('new-result.pdf');

        /*@ If already PDF exists then delete it */
        if (file_exists($savePdfPath)) {
            unlink($savePdfPath);
        }

        //Save it into PDF
        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
        $PDFWriter->save($savePdfPath);
        echo 'File has been successfully converted ' . $savePdfPath;

        /*@ Remove temporarily created word file */
        if (file_exists($saveDocPath)) {
            unlink($saveDocPath);
        }
        //return response()->file($savePdfPath);
    }

    public function generate()
    {

    }
}
