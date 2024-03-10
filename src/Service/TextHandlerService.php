<?php

namespace App\Service;

use App\Contracts\TextHandleServiceInterface;
use PhpOffice\PhpWord\Element\Link;
use PhpOffice\PhpWord\Element\ListItemRun;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;

class TextHandlerService implements TextHandleServiceInterface
{
    /**
     * @throws Exception
     */
    public function readDoc(string $textFile, string $dir): array
    {
        $objReader = IOFactory::createReader();
        $phpWord = $objReader->load($dir . '/' . $textFile);

        $texts = '';
        foreach ($phpWord->getSections() as $sections) {
            $array = $sections->getElements();

            foreach ($array as $item) {

                if (get_class($item) === TextRun::class) {
                    foreach ($item->getElements() as $text) {

                        if (get_class($text) === Text::class) {
                            $texts .= $text->getText();
                        }

                        if (get_class($text) === Link::class) {
                            $texts .= $text->getText();
                        }
                    }
                } else if (get_class($item) === ListItemRun::class) {
                    foreach ($item->getElements() as $text) {
                        if (get_class($text) === Text::class) {
                            $texts .= ' • ' . $text->getText();
                        }

                    }
                }
                $texts .= '\n';
            }
        }

        $arrayText = explode('\n', $texts);

        return array_diff($arrayText, array('', NULL, false, ' '));
    }


    public function handleText(array $arrayText): string
    {
        $textWithTags = [];

        foreach ($arrayText as $key => $txt) {

            if (strpos($txt, '***h1')) {
                $openTagH1 = preg_replace('/[*h1]|[.]/', '', $txt);
                $textWithTags[] = '<h2>' .trim($openTagH1) . '</h2>';
            }

            if (strpos($txt, '•')) {
                $tagLi = str_replace('•', '', $txt);
                $textWithTags[] = '<li>' . $tagLi . '</li>';

                if (array_key_exists($key + 1, $arrayText)) {
                    if (!strpos($arrayText[$key + 1], '•')) {
                        $textWithTags[] = '</ul>';
                    }
                }
            } else if (str_ends_with($txt, ':')) {
                $textWithTags[] = '<p>' . $txt . '</p><ul>';
            } else {
                if (str_contains($txt, "!Важно!")) {
                    $textWithTags[] = '<p class="vazno">' . str_replace('!Важно!', '', $txt) . '</p>';
                } else {
                    $textWithTags[] = '<p>' . $txt . '</p>';
                }
            }

            $val = '<p>' . $txt . '</p>';
            if (strpos($val, '***h1') || strpos($val, '***h2')) {
                $idx = array_search($val, $textWithTags);
                unset($textWithTags[$idx]);
            }
        }

        return implode('', $textWithTags);
    }


}