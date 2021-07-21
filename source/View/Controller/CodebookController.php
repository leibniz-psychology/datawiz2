<?php


namespace App\View\Controller;



use App\Codebook\MeasureOptionsModell;
use App\Crud\Crudable;
use App\Domain\Model\Codebook\DatasetMetaData;
use App\Codebook\MetaDataExchangeModell;
use App\Codebook\ValuePairModell;
use App\Codebook\VariableModell;
use App\Domain\Model\Study\Experiment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/codebook", name="Codebook-")
 * @IsGranted("ROLE_USER")
 *
 * Class CodebookController
 * @package App\View\Controller
 */
class CodebookController extends DataWizController
{
    /**
     * @Route("/{uuid}/data", name="dataupdate")
     *
     * @param string $uuid
     * @param Request $request
     * @return JsonResponse
     */
    public function dataUpdateCall(string $uuid, Request $request)
    {
        if ($request->isMethod("POST")) {
            $postedData = $this->convertCodebookFrom($request);

            // test the update with just one entity before wiring the uuid's correctly
            /** @var DatasetMetaData $entityAtChange */
            $entityAtChange = $this->crud->readForAll(DatasetMetaData::class)[0];
            $this->updateDatasetMetaData($entityAtChange, $postedData);
        } else {
            // test the update with just one entity before wiring the uuid's correctly
            /** @var DatasetMetaData $entityAtChange */
            $entityAtChange = $this->crud->readForAll(DatasetMetaData::class)[0];
        }

        $returnDummy = MetaDataExchangeModell::createFrom(
            [
                VariableModell::createFrom(
                    "1",
                    "ID",
                    "Versuchspersonennummer (niedrige Ziffern kennzeichnen junge, hohe Ziffern alte Vpn)",
                    "DDataWiz-Data was loaded from DB",
                    [
                        ValuePairModell::createFrom("", "")
                    ],
                    [
                        ValuePairModell::createFrom("", "")
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "2",
                    "SD",
                    "Versuchsbedingung: Gedächtnisbelastung",
                    "",
                    [

                        ValuePairModell::createFrom("0", "1 Aufgabe, Darbietung aufeinanderfolgender Rechenoperationen in zwei Kästchen"),
                        ValuePairModell::createFrom("1", "1 Aufgabe"),
                        ValuePairModell::createFrom("2", "2 Aufgaben"),
                        ValuePairModell::createFrom("3", "3 Aufgaben"),
                        ValuePairModell::createFrom("4", "4 Aufgaben")

                    ],
                    [
                        ValuePairModell::createFrom("0", "no"),
                        ValuePairModell::createFrom("1", "ohno")
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "3",
                    "ITEM",
                    "Itemnummer (Durchgang je Bedingung)",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "4",
                    "PT1",
                    "Präsentationszeit",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "5",
                    "PT",
                    "Präsentationszeit gemessen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "6",
                    "NO",
                    "Darbietungszeitkategorie",
                    "",
                    [
                        ValuePairModell::createFrom("1", "kurz"),
                        ValuePairModell::createFrom("2", "mittel"),
                        ValuePairModell::createFrom("3", "lang"),
                        ValuePairModell::createFrom("4", "sehr lang, 6 sec"),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "7",
                    "CRIT",
                    "Kriterium für den adaptiven Prozess (Anteil korrekter Endwerte im Durchgang, abhängig von Bedingung)",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "8",
                    "X1",
                    "Richtiger Endwert im ersten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "9",
                    "Y1",
                    "Eingegebener Endwert im ersten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    "Accuracy of memory (percentage of correct answers)"
                ),
                VariableModell::createFrom(
                    "10",
                    "CORR1",
                    "Korrektheit des eingegebenen Wertes des ersten Kästchens",
                    "",
                    [
                        ValuePairModell::createFrom("0", "falsch"),
                        ValuePairModell::createFrom("1", "richtig"),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "11",
                    "RT1",
                    "Eingabezeit für das erste Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    "Reaction times for keying in the first results (ms)"
                ),
                VariableModell::createFrom(
                    "12",
                    "X2",
                    "Richtiger Endwert im zweiten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "13",
                    "Y2",
                    "Eingegebener Endwert im zweiten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    "Accuracy of memory (percentage of correct answers)"
                ),
                VariableModell::createFrom(
                    "14",
                    "CORR2",
                    "Korrektheit des eingegebenen Wertes des zweiten Kästchens",
                    "",
                    [
                        ValuePairModell::createFrom("0", "falsch"),
                        ValuePairModell::createFrom("1", "richtig"),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "15",
                    "RT2",
                    "Eingabezeit für das zweite Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    "Reaction times for keying in the first results (ms)"
                ),
                VariableModell::createFrom(
                    "16",
                    "X3",
                    "Richtiger Endwert im dritten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "17",
                    "Y3",
                    "Eingegebener Endwert im dritten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    "Accuracy of memory (percentage of correct answers)"
                ),
                VariableModell::createFrom(
                    "18",
                    "CORR3",
                    "Korrektheit des eingegebenen Wertes des dritten Kästchens",
                    "",
                    [
                        ValuePairModell::createFrom("0", "falsch"),
                        ValuePairModell::createFrom("1", "richtig"),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "19",
                    "RT3",
                    "Eingabezeit für das dritte Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    "Reaction times for keying in the first results (ms)"
                ),
                VariableModell::createFrom(
                    "20",
                    "X4",
                    "Richtiger Endwert im vierten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "21",
                    "Y4",
                    "Eingegebener Endwert im vierten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    "Accuracy of memory (percentage of correct answers)"
                ),
                VariableModell::createFrom(
                    "22",
                    "CORR4",
                    "Korrektheit des eingegebenen Wertes des vierten Kästchens",
                    "",
                    [
                        ValuePairModell::createFrom("0", "falsch"),
                        ValuePairModell::createFrom("1", "richtig"),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "23",
                    "RT4",
                    "Eingabezeit für das vierte Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    "Reaction times for keying in the first results (ms)"
                ),
            ]
        )->getJsonString();

        return JsonResponse::fromJsonString($returnDummy);
    }

    /**
     * @Route("/{uuid}/measures", name="measures")
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function measuresCall(string $uuid)
    {
        // search for the codebook entity
        // get experiment id
        // get measures from there
        // create actual MeasureOptionsModell from the data

        $dummyMeasures = MeasureOptionsModell::createFrom(
            array("Accuracy of memory (percentage of correct answers)", "Reaction times for keying in the first results (ms)")
        )
            ->getJsonString();

        return JsonResponse::fromJsonString($dummyMeasures);
    }

    private function updateDatasetMetaData(DatasetMetaData $entityAtChange, array $metadataAsArray)
    {
        $entityAtChange->setMetadata($metadataAsArray);
        $this->crud->update($entityAtChange);
    }

    private function convertCodebookFrom(Request $request)
    {
        return json_decode($request->getContent(), true);
    }

    /**
     * @Route("/{uuid}/index", name="index")
     *
     * @param string $uuid
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function codebookIndexAction(string $uuid, Request $request)
    {
        $returnDummy = MetaDataExchangeModell::createFrom(
            [
                VariableModell::createFrom(
                    "1",
                    "ID",
                    "Versuchspersonennummer (niedrige Ziffern kennzeichnen junge, hohe Ziffern alte Vpn)",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", "")
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "2",
                    "SD",
                    "Versuchsbedingung: Gedächtnisbelastung",
                    "",
                    [

                        ValuePairModell::createFrom("0", "1 Aufgabe, Darbietung aufeinanderfolgender Rechenoperationen in zwei Kästchen"),
                        ValuePairModell::createFrom("1", "1 Aufgabe"),
                        ValuePairModell::createFrom("2", "2 Aufgaben"),
                        ValuePairModell::createFrom("3", "3 Aufgaben"),
                        ValuePairModell::createFrom("4", "4 Aufgaben")

                    ],
                    [
                        ValuePairModell::createFrom("0", "no"),
                        ValuePairModell::createFrom("1", "ohno")
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "3",
                    "ITEM",
                    "Itemnummer (Durchgang je Bedingung)",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", "")
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "4",
                    "PT1",
                    "Präsentationszeit",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", "")
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "5",
                    "PT",
                    "Präsentationszeit gemessen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "6",
                    "NO",
                    "Darbietungszeitkategorie",
                    "",
                    [
                        ValuePairModell::createFrom("1", "kurz"),
                        ValuePairModell::createFrom("2", "mittel"),
                        ValuePairModell::createFrom("3", "lang"),
                        ValuePairModell::createFrom("4", "sehr lang, 6 sec"),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "7",
                    "CRIT",
                    "Kriterium für den adaptiven Prozess (Anteil korrekter Endwerte im Durchgang, abhängig von Bedingung)",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "8",
                    "X1",
                    "Richtiger Endwert im ersten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "9",
                    "Y1",
                    "Eingegebener Endwert im ersten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    "Accuracy of memory (percentage of correct answers)"
                ),
                VariableModell::createFrom(
                    "10",
                    "CORR1",
                    "Korrektheit des eingegebenen Wertes des ersten Kästchens",
                    "",
                    [
                        ValuePairModell::createFrom("0", "falsch"),
                        ValuePairModell::createFrom("1", "richtig"),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "11",
                    "RT1",
                    "Eingabezeit für das erste Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    "Reaction times for keying in the first results (ms)"
                ),
                VariableModell::createFrom(
                    "12",
                    "X2",
                    "Richtiger Endwert im zweiten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "13",
                    "Y2",
                    "Eingegebener Endwert im zweiten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    "Accuracy of memory (percentage of correct answers)"
                ),
                VariableModell::createFrom(
                    "14",
                    "CORR2",
                    "Korrektheit des eingegebenen Wertes des zweiten Kästchens",
                    "",
                    [
                        ValuePairModell::createFrom("0", "falsch"),
                        ValuePairModell::createFrom("1", "richtig"),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "15",
                    "RT2",
                    "Eingabezeit für das zweite Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    "Reaction times for keying in the first results (ms)"
                ),
                VariableModell::createFrom(
                    "16",
                    "X3",
                    "Richtiger Endwert im dritten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "17",
                    "Y3",
                    "Eingegebener Endwert im dritten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    "Accuracy of memory (percentage of correct answers)"
                ),
                VariableModell::createFrom(
                    "18",
                    "CORR3",
                    "Korrektheit des eingegebenen Wertes des dritten Kästchens",
                    "",
                    [
                        ValuePairModell::createFrom("0", "falsch"),
                        ValuePairModell::createFrom("1", "richtig"),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "19",
                    "RT3",
                    "Eingabezeit für das dritte Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    "Reaction times for keying in the first results (ms)"
                ),
                VariableModell::createFrom(
                    "20",
                    "X4",
                    "Richtiger Endwert im vierten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "21",
                    "Y4",
                    "Eingegebener Endwert im vierten Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    "Accuracy of memory (percentage of correct answers)"
                ),
                VariableModell::createFrom(
                    "22",
                    "CORR4",
                    "Korrektheit des eingegebenen Wertes des vierten Kästchens",
                    "",
                    [
                        ValuePairModell::createFrom("0", "falsch"),
                        ValuePairModell::createFrom("1", "richtig"),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    ""
                ),
                VariableModell::createFrom(
                    "23",
                    "RT4",
                    "Eingabezeit für das vierte Kästchen",
                    "",
                    [
                        ValuePairModell::createFrom("", ""),
                    ],
                    [
                        ValuePairModell::createFrom("99999", "fehlender Wert, aufgrund Versuchsbedingung"),
                    ],
                    "Reaction times for keying in the first results (ms)"
                ),
            ]
        )->getJsonString();

        $entityAtDisplay = $this->getEntityAtChange($uuid);

        return $this->render('Pages/Codebook/index.html.twig', [
            'codebook' => $entityAtDisplay,
            'dummy' => $returnDummy
        ]);
    }

    protected function getEntityAtChange(string $uuid, string $className = DatasetMetaData::class)
    {
        /**
         * TODO: This logic should live in the crud service and should be refactor into it's own interface
         */
        // will not work with a proper relation to an experiment - refactor needed
        $entityAtChange = $this->crud->readById($className, $uuid);
        if ($entityAtChange === null) {
            $entityAtChange = DatasetMetaData::createEmptyCode();
            $this->crud->update($entityAtChange);
        }

        return $entityAtChange;
    }
}
