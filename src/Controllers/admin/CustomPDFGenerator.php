<?php
namespace App\Controllers\admin;

class CustomPDFGenerator {
    private $objects = [];
    private $page = '';

    public function generateSessionsPDF($sessions) {
        try {
            // Validate input
            if (empty($sessions)) {
                throw new \Exception('No sessions data provided');
            }

            // Start PDF generation
            $this->createPDFStructure($sessions);

            // Output PDF
            $pdfContent = implode('', $this->objects);
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="sessions_report_' . date('Y-m-d') . '.pdf"');
            header('Content-Length: ' . strlen($pdfContent));
            
            echo $pdfContent;
            exit();

        } catch (\Exception $e) {
            error_log('PDF Generation Error: ' . $e->getMessage());
            
            header('Content-Type: text/plain');
            echo 'PDF Generation Failed: ' . $e->getMessage();
            exit();
        }
    }

    private function createPDFStructure($sessions) {
        // PDF Header
        $this->objects[] = "%PDF-1.7\n%\xC2\xA5\xC2\xB5\xC3\x87\n";

        // Catalog Object
        $this->addObject(1, "<<\n/Type /Catalog\n/Pages 2 0 R\n>>");

        // Pages Object
        $this->addObject(2, "<<\n/Type /Pages\n/Kids [3 0 R]\n/Count 1\n>>");

        // Font Object
        $this->addObject(4, "<<\n/Type /Font\n/Subtype /Type1\n/Name /F1\n/BaseFont /Helvetica\n>>");

        // Prepare page content
        $this->preparePage($sessions);
    }

    private function addObject($id, $content) {
        $this->objects[$id] = "$id 0 obj\n$content\nendobj\n";
    }

    private function preparePage($sessions) {
        // Page Object
        $contentObjectId = 5;
        $this->addObject(3, "<<\n" . 
            "/Type /Page\n" . 
            "/Parent 2 0 R\n" . 
            "/Resources <<\n" . 
            "  /Font <<\n" . 
            "    /F1 4 0 R\n" . 
            "  >>\n" . 
            "  /ProcSet [/PDF /Text]\n" . 
            ">>\n" . 
            "/MediaBox [0 0 595 842]\n" . 
            "/Contents $contentObjectId 0 R\n" . 
            ">>");

        // Prepare page content
        $pageContent = $this->createPageContent($sessions);

        // Content Object
        $this->addObject($contentObjectId, "<<\n/Length " . strlen($pageContent) . "\n>>\nstream\n" . $pageContent . "\nendstream");

        // Generate cross-reference and trailer
        $this->generateXref();
    }

    private function createPageContent($sessions) {
        $content = "q\n"; // Start graphics state
        $content .= "/F1 12 Tf\n"; // Set font

        // Add title
        $content .= "BT\n";
        $content .= "50 800 Td\n"; // Position
        $content .= "/F1 16 Tf\n"; // Larger font
        $content .= $this->escapeString("Sessions Report - " . date('Y-m-d')) . " Tj\n";
        $content .= "ET\n";

        // Prepare table headers
        $headers = [
            'Session ID', 'Student', 'Tutor', 'Date', 
            'Time', 'Status', 'Subject', 'Payment Status'
        ];

        // Table headers
        $content .= "BT\n/F1 10 Tf\n";
        $y = 750;

        // Add headers
        foreach ($headers as $index => $header) {
            $x = 50 + ($index * 70);
            $content .= "1 0 0 1 $x $y Tm\n";
            $content .= $this->escapeString($header) . " Tj\n";
        }

        // Add rows
        $y -= 20;
        foreach ($sessions as $session) {
            $row = [
                $session['session_id'] ?? '',
                ($session['student_first_name'] ?? '') . ' ' . ($session['student_last_name'] ?? ''),
                ($session['tutor_first_name'] ?? '') . ' ' . ($session['tutor_last_name'] ?? ''),
                $session['scheduled_date'] ?? '',
                $session['schedule_time'] ?? '',
                $session['session_status'] ?? '',
                $session['subject_name'] ?? '',
                $session['payment_status'] ?? ''
            ];

            foreach ($row as $index => $value) {
                $x = 50 + ($index * 70);
                $content .= "1 0 0 1 $x $y Tm\n";
                $content .= $this->escapeString($value) . " Tj\n";
            }
            $y -= 20;
        }

        $content .= "ET\n";
        $content .= "Q\n"; // End graphics state

        return $content;
    }

    private function escapeString($text) {
        $text = str_replace(
            ['\\', '(', ')', "\r", "\n"], 
            ['\\\\', '\\(', '\\)', '\\r', '\\n'], 
            $text
        );
        return "($text)";
    }

    private function generateXref() {
        $objectOffsets = [0];
        $xrefStart = 0;
        
        // Calculate object offsets
        foreach ($this->objects as $object) {
            $objectOffsets[] = $xrefStart;
            $xrefStart += strlen($object);
        }

        // Generate xref section
        $xref = "xref\n0 " . count($objectOffsets) . "\n";
        foreach ($objectOffsets as $offset) {
            $xref .= sprintf("%010d 00000 n\n", $offset);
        }

        // Add trailer
        $uniqueId = md5(uniqid(microtime(), true));
        $xref .= "trailer\n<<\n" .
            "/Size " . count($objectOffsets) . "\n" .
            "/Root 1 0 R\n" .
            "/ID [<$uniqueId><$uniqueId>]\n" .
            ">>\n" .
            "startxref\n$xrefStart\n" .
            "%%EOF\n";

        $this->objects[] = $xref;
    }
}
?>