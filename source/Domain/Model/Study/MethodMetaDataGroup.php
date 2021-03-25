<?php


namespace App\Domain\Model\Study;


use App\Domain\Definition\MetaDataDictionary;
use App\Domain\Definition\MetaDataValuable;
use App\Domain\Definition\Study\Assignable;
use App\Domain\Definition\Study\ControlOperationable;
use App\Domain\Definition\Study\ExperimentalDesignable;
use App\Domain\Definition\Study\Manipulatable;
use App\Domain\Definition\Study\ResearchDesignable;
use App\Domain\Definition\Study\Settable;
use App\Domain\Model\Administration\UuidEntity;
use App\Questionnaire\Forms\MethodType;
use App\Questionnaire\Questionable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class MethodMetaDataGroup  extends UuidEntity implements MetaDataValuable, Questionable
{
    /**
     * One basic Information section has One Experiment.
     *
     * @ORM\OneToOne(targetEntity="App\Domain\Model\Study\Experiment", inversedBy="methodMetaDataGroup")
     */
    protected $experiment;
    use ExperimentRelatable;

    use Settable;
    use ResearchDesignable;
    use Manipulatable;
    use Assignable;
    use ExperimentalDesignable;
    use ControlOperationable;

    public static function getImplementedMetaData(): array
    {
        return [
            MetaDataDictionary::SETTING,
            MetaDataDictionary::RESEARCH_DESIGN,
            MetaDataDictionary::MANIPULATIONS,
            MetaDataDictionary::ASSIGNMENT,
            MetaDataDictionary::EXPERIMENTAL_DESIGN,
            MetaDataDictionary::CONTROL_OPERATIONS
        ];
    }

    public function getFormTypeForEntity(): string
    {
        return MethodType::class;
    }
}