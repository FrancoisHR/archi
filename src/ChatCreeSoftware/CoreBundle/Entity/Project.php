<?php

namespace ChatCreeSoftware\CoreBundle\Entity;

use Symfony\Component\Finder\Finder;

/**
 * Project
 */
class Project
{
    private static $PROJECT_ROOT = "projects/";
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $projectName;

    /**
     * @var string
     */
    private $projectPath;

    /**
     * @var \DateTime
     */
    private $projectStart;

    /**
     * @var \DateTime
     */
    private $projectEnd;

    /**
     * @var \DateTime
     */
    private $authDate;

    /**
     * @var \DateTime
     */
    private $workStart;

    /**
     * @var float
     */
    private $projectBudget;

    /**
     * @var float
     */
    private $projectPrice;

    /**
     * @var string
     */
    private $projectDesc;

    /**
     * @var string
     */
    private $projectNote;

    /**
     * @var string
     */
    private $addressStreet1;

    /**
     * @var string
     */
    private $addressStreet2;

    /**
     * @var string
     */
    private $addressCity;

    /**
     * @var string
     */
    private $addressCP;

    /**
     * @var string
     */
    private $addressCountry;

    /**
     * @var string
     */
    private $cadastre;

    /**
     * @var string
     */
    private $section;

    /**
     * @var string
     */
    private $commune;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $addresses;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $timeLogs;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $invoices;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tasks;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $journeys;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $logbook;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $bordereaux;

    /**
     * @var \ChatCreeSoftware\CoreBundle\Entity\Flags
     */
    private $projectType;

    /**
     * @var \ChatCreeSoftware\CoreBundle\Entity\Flags
     */
    private $projectStatus;

    /**
     * @var \ChatCreeSoftware\CoreBundle\Entity\Flags
     */
    private $projectContract;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timeLogs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->invoices = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->journeys = new \Doctrine\Common\Collections\ArrayCollection();
        $this->logbook = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bordereaux = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set projectName
     *
     * @param string $projectName
     *
     * @return Project
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Get projectName
     *
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * Set projectPath
     *
     * @param string $projectPath
     *
     * @return Project
     */
    public function setProjectPath($projectPath)
    {
        $this->projectPath = $projectPath;

        return $this;
    }

    /**
     * Get projectPath
     *
     * @return string
     */
    public function getProjectPath()
    {
        return $this->projectPath;
    }

    function getFolders() {
        $folderFinder = new Finder();
        $folderIterator = $folderFinder->directories()
                    ->depth('< 1')
                    ->in($this->getProjectPath());
        $darray = iterator_to_array($folderIterator);
        uasort( $darray, create_function('$a,$b', 'return strnatcasecmp($a->getFilename(), $b->getFilename());') );
            
        return new \ArrayIterator($darray);
    }
    
    function getFiles( $folderpath ) {
        $fileFinder = new Finder();
        $fileIterator = $fileFinder->files()
                ->notName('.*')
                ->depth('< 1')
                ->in($this->getProjectPath() . $folderpath);
        $farray = iterator_to_array($fileIterator);
        uasort( $farray, create_function('$a,$b', 'return strnatcasecmp($a->getFilename(), $b->getFilename());') );

        return new \ArrayIterator($farray);        
    }
    
    function createPath($str, $encoding = 'utf-8') {
        mb_regex_encoding($encoding); // jeu de caractères courant pour les expressions rationnelles. 
        // Tableau des corespondance
        $str_ascii = array(
            'A' => 'ÀÁÂÃÄÅĀĂǍẠẢẤẦẨẪẬẮẰẲẴẶǺĄ',
            'a' => 'àáâãäåāăǎạảấầẩẫậắằẳẵặǻą',
            'C' => 'ÇĆĈĊČ',
            'c' => 'çćĉċč',
            'D' => 'ÐĎĐ',
            'd' => 'ďđ',
            'E' => 'ÈÉÊËĒĔĖĘĚẸẺẼẾỀỂỄỆ',
            'e' => 'èéêëēĕėęěẹẻẽếềểễệ',
            'G' => 'ĜĞĠĢ',
            'g' => 'ĝğġģ',
            'H' => 'ĤĦ',
            'h' => 'ĥħ',
            'I' => 'ÌÍÎÏĨĪĬĮİǏỈỊ',
            'J' => 'Ĵ',
            'j' => 'ĵ',
            'K' => 'Ķ',
            'k' => 'ķ',
            'L' => 'ĹĻĽĿŁ',
            'l' => 'ĺļľŀł',
            'N' => 'ÑŃŅŇ',
            'n' => 'ñńņňŉ',
            'O' => 'ÒÓÔÕÖØŌŎŐƠǑǾỌỎỐỒỔỖỘỚỜỞỠỢ',
            'o' => 'òóôõöøōŏőơǒǿọỏốồổỗộớờởỡợð',
            'R' => 'ŔŖŘ',
            'r' => 'ŕŗř',
            'S' => 'ŚŜŞŠ',
            's' => 'śŝşš',
            'T' => 'ŢŤŦ',
            't' => 'ţťŧ',
            'U' => 'ÙÚÛÜŨŪŬŮŰŲƯǓǕǗǙǛỤỦỨỪỬỮỰ',
            'u' => 'ùúûüũūŭůűųưǔǖǘǚǜụủứừửữự',
            'W' => 'ŴẀẂẄ',
            'w' => 'ŵẁẃẅ',
            'Y' => 'ÝŶŸỲỸỶỴ',
            'y' => 'ýÿŷỹỵỷỳ',
            'Z' => 'ŹŻŽ',
            'z' => 'źżž',
            // Ligatures
            'AE' => 'Æ',
            'ae' => 'æ',
            'OE' => 'Œ',
            'oe' => 'œ',
        );

        // Convertion
        foreach ($str_ascii as $k => $v) {
            $str = mb_ereg_replace('[' . $v . ']', $k, $str);
        }

        // replace space by '_'
        $str = str_replace(' ', '_', $str);
        // remove all specials
        $specials = array( '@', '#', '&','"','\'','(','§','!',')','-','$','*','€','%','£','`','<','>',',','?',';','.',':','/','=','+');
        $str = str_replace($specials, '', $str);

        $this->setProjectPath(Project::$PROJECT_ROOT . $str);
    }
    
    
    /**
     * Set projectStart
     *
     * @param \DateTime $projectStart
     *
     * @return Project
     */
    public function setProjectStart($projectStart)
    {
        $this->projectStart = $projectStart;

        return $this;
    }

    /**
     * Get projectStart
     *
     * @return \DateTime
     */
    public function getProjectStart()
    {
        return $this->projectStart;
    }

    /**
     * Set projectEnd
     *
     * @param \DateTime $projectEnd
     *
     * @return Project
     */
    public function setProjectEnd($projectEnd)
    {
        $this->projectEnd = $projectEnd;

        return $this;
    }

    /**
     * Get projectEnd
     *
     * @return \DateTime
     */
    public function getProjectEnd()
    {
        return $this->projectEnd;
    }

    /**
     * Set authDate
     *
     * @param \DateTime $authDate
     *
     * @return Project
     */
    public function setAuthDate($authDate)
    {
        $this->authDate = $authDate;

        return $this;
    }

    /**
     * Get authDate
     *
     * @return \DateTime
     */
    public function getAuthDate()
    {
        return $this->authDate;
    }

    /**
     * Set workStart
     *
     * @param \DateTime $workStart
     *
     * @return Project
     */
    public function setWorkStart($workStart)
    {
        $this->workStart = $workStart;

        return $this;
    }

    /**
     * Get workStart
     *
     * @return \DateTime
     */
    public function getWorkStart()
    {
        return $this->workStart;
    }

    /**
     * Set projectBudget
     *
     * @param float $projectBudget
     *
     * @return Project
     */
    public function setProjectBudget($projectBudget)
    {
        $this->projectBudget = $projectBudget;

        return $this;
    }

    /**
     * Get projectBudget
     *
     * @return float
     */
    public function getProjectBudget()
    {
        return $this->projectBudget;
    }

    /**
     * Set projectPrice
     *
     * @param float $projectPrice
     *
     * @return Project
     */
    public function setProjectPrice($projectPrice)
    {
        $this->projectPrice = $projectPrice;

        return $this;
    }

    /**
     * Get projectPrice
     *
     * @return float
     */
    public function getProjectPrice()
    {
        return $this->projectPrice;
    }

    /**
     * Set projectDesc
     *
     * @param string $projectDesc
     *
     * @return Project
     */
    public function setProjectDesc($projectDesc)
    {
        $this->projectDesc = $projectDesc;

        return $this;
    }

    /**
     * Get projectDesc
     *
     * @return string
     */
    public function getProjectDesc()
    {
        return $this->projectDesc;
    }

    /**
     * Set projectNote
     *
     * @param string $projectNote
     *
     * @return Project
     */
    public function setProjectNote($projectNote)
    {
        $this->projectNote = $projectNote;

        return $this;
    }

    /**
     * Get projectNote
     *
     * @return string
     */
    public function getProjectNote()
    {
        return $this->projectNote;
    }

    /**
     * Set addressStreet1
     *
     * @param string $addressStreet1
     *
     * @return Project
     */
    public function setAddressStreet1($addressStreet1)
    {
        $this->addressStreet1 = $addressStreet1;

        return $this;
    }

    /**
     * Get addressStreet1
     *
     * @return string
     */
    public function getAddressStreet1()
    {
        return $this->addressStreet1;
    }

    /**
     * Set addressStreet2
     *
     * @param string $addressStreet2
     *
     * @return Project
     */
    public function setAddressStreet2($addressStreet2)
    {
        $this->addressStreet2 = $addressStreet2;

        return $this;
    }

    /**
     * Get addressStreet2
     *
     * @return string
     */
    public function getAddressStreet2()
    {
        return $this->addressStreet2;
    }

    /**
     * Set addressCity
     *
     * @param string $addressCity
     *
     * @return Project
     */
    public function setAddressCity($addressCity)
    {
        $this->addressCity = $addressCity;

        return $this;
    }

    /**
     * Get addressCity
     *
     * @return string
     */
    public function getAddressCity()
    {
        return $this->addressCity;
    }

    /**
     * Set addressCP
     *
     * @param string $addressCP
     *
     * @return Project
     */
    public function setAddressCP($addressCP)
    {
        $this->addressCP = $addressCP;

        return $this;
    }

    /**
     * Get addressCP
     *
     * @return string
     */
    public function getAddressCP()
    {
        return $this->addressCP;
    }

    /**
     * Set addressCountry
     *
     * @param string $addressCountry
     *
     * @return Project
     */
    public function setAddressCountry($addressCountry)
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    /**
     * Get addressCountry
     *
     * @return string
     */
    public function getAddressCountry()
    {
        return $this->addressCountry;
    }

    /**
     * Set cadastre
     *
     * @param string $cadastre
     *
     * @return Project
     */
    public function setCadastre($cadastre)
    {
        $this->cadastre = $cadastre;

        return $this;
    }

    /**
     * Get cadastre
     *
     * @return string
     */
    public function getCadastre()
    {
        return $this->cadastre;
    }

    /**
     * Set section
     *
     * @param string $section
     *
     * @return Project
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set commune
     *
     * @param string $commune
     *
     * @return Project
     */
    public function setCommune($commune)
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * Get commune
     *
     * @return string
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * Add address
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\Address $address
     *
     * @return Project
     */
    public function addAddress(\ChatCreeSoftware\ProjectManagementBundle\Entity\Address $address)
    {
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\Address $address
     */
    public function removeAddress(\ChatCreeSoftware\ProjectManagementBundle\Entity\Address $address)
    {
        $this->addresses->removeElement($address);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add timeLog
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog $timeLog
     *
     * @return Project
     */
    public function addTimeLog(\ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog $timeLog)
    {
        $this->timeLogs[] = $timeLog;

        return $this;
    }

    /**
     * Remove timeLog
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog $timeLog
     */
    public function removeTimeLog(\ChatCreeSoftware\ProjectManagementBundle\Entity\TimeLog $timeLog)
    {
        $this->timeLogs->removeElement($timeLog);
    }

    /**
     * Get timeLogs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTimeLogs()
    {
        return $this->timeLogs;
    }

    /**
     * Add invoice
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\Invoicing $invoice
     *
     * @return Project
     */
    public function addInvoice(\ChatCreeSoftware\ProjectManagementBundle\Entity\Invoicing $invoice)
    {
        $this->invoices[] = $invoice;

        return $this;
    }

    /**
     * Remove invoice
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\Invoicing $invoice
     */
    public function removeInvoice(\ChatCreeSoftware\ProjectManagementBundle\Entity\Invoicing $invoice)
    {
        $this->invoices->removeElement($invoice);
    }

    /**
     * Get invoices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvoices()
    {
        return $this->invoices;
    }

    /**
     * Add task
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\Task $task
     *
     * @return Project
     */
    public function addTask(\ChatCreeSoftware\ProjectManagementBundle\Entity\Task $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Remove task
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\Task $task
     */
    public function removeTask(\ChatCreeSoftware\ProjectManagementBundle\Entity\Task $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Add journey
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\Journey $journey
     *
     * @return Project
     */
    public function addJourney(\ChatCreeSoftware\ProjectManagementBundle\Entity\Journey $journey)
    {
        $this->journeys[] = $journey;

        return $this;
    }

    /**
     * Remove journey
     *
     * @param \ChatCreeSoftware\ProjectManagementBundle\Entity\Journey $journey
     */
    public function removeJourney(\ChatCreeSoftware\ProjectManagementBundle\Entity\Journey $journey)
    {
        $this->journeys->removeElement($journey);
    }

    /**
     * Get journeys
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJourneys()
    {
        return $this->journeys;
    }

    /**
     * Add logbook
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\LogBook $logbook
     *
     * @return Project
     */
    public function addLogbook(\ChatCreeSoftware\CoreBundle\Entity\LogBook $logbook)
    {
        $this->logbook[] = $logbook;

        return $this;
    }

    /**
     * Remove logbook
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\LogBook $logbook
     */
    public function removeLogbook(\ChatCreeSoftware\CoreBundle\Entity\LogBook $logbook)
    {
        $this->logbook->removeElement($logbook);
    }

    /**
     * Get logbook
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogbook()
    {
        return $this->logbook;
    }

    /**
     * Add bordereaux
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Bordereau $bordereaux
     *
     * @return Project
     */
    public function addBordereaux(\ChatCreeSoftware\BordereauxBundle\Entity\Bordereau $bordereaux)
    {
        $this->bordereaux[] = $bordereaux;

        return $this;
    }

    /**
     * Remove bordereaux
     *
     * @param \ChatCreeSoftware\BordereauxBundle\Entity\Bordereau $bordereaux
     */
    public function removeBordereaux(\ChatCreeSoftware\BordereauxBundle\Entity\Bordereau $bordereaux)
    {
        $this->bordereaux->removeElement($bordereaux);
    }

    /**
     * Get bordereaux
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBordereaux()
    {
        return $this->bordereaux;
    }

    /**
     * Set projectType
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\Flags $projectType
     *
     * @return Project
     */
    public function setProjectType(\ChatCreeSoftware\CoreBundle\Entity\Flags $projectType = null)
    {
        $this->projectType = $projectType;

        return $this;
    }

    /**
     * Get projectType
     *
     * @return \ChatCreeSoftware\CoreBundle\Entity\Flags
     */
    public function getProjectType()
    {
        return $this->projectType;
    }

    /**
     * Set projectStatus
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\Flags $projectStatus
     *
     * @return Project
     */
    public function setProjectStatus(\ChatCreeSoftware\CoreBundle\Entity\Flags $projectStatus = null)
    {
        $this->projectStatus = $projectStatus;

        return $this;
    }

    /**
     * Get projectStatus
     *
     * @return \ChatCreeSoftware\CoreBundle\Entity\Flags
     */
    public function getProjectStatus()
    {
        return $this->projectStatus;
    }

    /**
     * Set projectContract
     *
     * @param \ChatCreeSoftware\CoreBundle\Entity\Flags $projectContract
     *
     * @return Project
     */
    public function setProjectContract(\ChatCreeSoftware\CoreBundle\Entity\Flags $projectContract = null)
    {
        $this->projectContract = $projectContract;

        return $this;
    }

    /**
     * Get projectContract
     *
     * @return \ChatCreeSoftware\CoreBundle\Entity\Flags
     */
    public function getProjectContract()
    {
        return $this->projectContract;
    }
    
    /**
     * Create new folder
     */
    public function createFolder( $rootpath, $folderpath, $foldername ){
        $rootDir = "$rootpath/" . $this->getProjectPath() . $folderpath;

        mkdir( $rootDir . "/" . $foldername, 0705 );
    }
    
    public function calculatePath( $directory, $entity, $foldername, $bordereauId=0 ) {
        $projectPath=$this->getProjectPath();

        switch( $entity ){
            case "Bordereau":
                $folderpath = "/.bordereaux/" . $bordereauId;
                break;
            case "Project":
            default:
                if (isset($foldername)) {
                    $folderpath = "/" . $foldername;
                } else {
                    $folderpath = "";
                }
                break;
        }
        return "$directory/$projectPath$folderpath";
    }

    protected function rmdir_recursive($dir) {
        if(file_exists( $dir )){
            $dirIt = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS );
            $it = new \RecursiveIteratorIterator($dirIt, \RecursiveIteratorIterator::CHILD_FIRST);
            foreach($it as $file) {
                if ($file->isDir()) {
                    rmdir($file->getPathname());
                }
                else {
                    unlink($file->getPathname());
                }
            }
            rmdir($dir);
        }
    }


    public function deletePath( $directory, $entity, $foldername, $bordereauId=0 ) {
        $path = $this->calculatePath( $directory, $entity, $foldername, $bordereauId );
        
        $this->rmdir_recursive( $path );
    }
}
