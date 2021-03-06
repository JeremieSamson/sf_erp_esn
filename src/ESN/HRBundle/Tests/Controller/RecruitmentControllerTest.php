<?php

namespace ESN\HRBundle\Tests;

use Doctrine\ORM\EntityManager;
use ESN\HRBundle\Entity\Apply;
use Faker\Factory;
use Faker\Generator;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;

class RecruitmentControllerTest extends WebTestCase
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Generator
     */
    private $faker;

    /**
     * @var EntityManager
     */
    private $manager;

    protected function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->crawler = $this->client->request(Request::METHOD_GET, '/human-ressources/recruitment/create');
        $this->faker = $faker = Factory::create();
        $this->manager = $this->getContainer()->get('doctrine.orm.entity_manager');

        $this->isSuccessful($this->client->getResponse());
    }

    public function testRecruitmentCreateFormContent()
    {
        $this->assertSame("Formulaire de recrutement", $this->crawler->filter("div.widget-content h2")->text());
        $this->assertContains(
            "Pour nous envoyer votre candidature, merci de remplir ce formulaire avec un maximum d'information.",
            $this->crawler->filter("div.widget-content div.alert-info")->text()
        );

        $this->assertCount(15, $this->crawler->filter("div.widget-content form fieldset div.control-group input"));
        $this->assertCount(21, $formElements = $this->crawler->filter("div.widget-content form fieldset div.control-group label"));
        $this->assertEquals("Prénom", $formElements->getNode(0)->textContent);
        $this->assertEquals("Nom", $formElements->getNode(1)->textContent);
        $this->assertEquals("Email", $formElements->getNode(2)->textContent);
        $this->assertEquals("Téléphone", $formElements->getNode(3)->textContent);
        $this->assertEquals("Facebook url", $formElements->getNode(4)->textContent);
        $this->assertEquals("Birthday", $formElements->getNode(5)->textContent);
        $this->assertEquals("Nationality", $formElements->getNode(6)->textContent);
        $this->assertCount(193, $this->crawler->filter("#form_apply_nationality option"));
        $this->assertEquals("Êtes-vous étudiant ?", $formElements->getNode(7)->textContent);
        $this->assertEquals("Êtes-vous partie en Erasmus ?", $formElements->getNode(8)->textContent);
        $this->assertEquals("Temps disponible ?", $formElements->getNode(9)->textContent);
        $this->assertEquals("Moins de 4 heures", $formElements->getNode(10)->textContent);
        $this->assertEquals("4 heures", $formElements->getNode(11)->textContent);
        $this->assertEquals("6 heures", $formElements->getNode(12)->textContent);
        $this->assertEquals("8 heures", $formElements->getNode(13)->textContent);
        $this->assertEquals("10 heures", $formElements->getNode(14)->textContent);
        $this->assertEquals("12 heures", $formElements->getNode(15)->textContent);
        $this->assertEquals("Plus de 12 heures", $formElements->getNode(16)->textContent);
        $this->assertEquals("Première langue", $formElements->getNode(17)->textContent);
        $this->assertEquals("Motivations ?", $formElements->getNode(18)->textContent);
        $this->assertEquals("Compétences ?", $formElements->getNode(19)->textContent);
        $this->assertEquals("Comment avez-vous connu ESN ?", $formElements->getNode(20)->textContent);
        $this->assertCount(1, $this->crawler->filter("div.widget-content form fieldset div.form-actions"));
    }

    public function testRecruitmentCreateFormAction()
    {
        $candidateInfos = [
            'form_apply' => [
                'firstname' => $this->faker->firstName,
                'lastname' => $this->faker->lastName,
                'birthdate' => $this->faker->date(),
                'nationality' => $this->pickRandomFieldValue("#form_apply_nationality option"),
                'email' =>  $email = $this->faker->email,
                'facebook_id' => $this->faker->url,
                'mobile' => $this->faker->phoneNumber,
                'student' => 1,
                'olderasmus' => 1,
                'availabletime' => $this->pickRandomFieldValue("#form_apply_availabletime input"),
                'languages' => $this->pickRandomFieldValue("#form_apply_languages option"),
                'motivation' => $this->faker->text,
                'skill' => $this->faker->text,
                'knowesn' => $this->faker->text,
            ]
        ];

        $this->client->submit($this->crawler->selectButton('Postuler')->form($candidateInfos));
        $this->isSuccessful($this->client->getResponse());

        $candidate = $this->manager->getRepository(Apply::class)->findOneBy(["email" => $email]);

        $this->assertTrue($candidate instanceof Apply);
        $this->assertSame($email, $candidate->getEmail());
    }

    private function pickRandomFieldValue($fieldSelector)
    {
        $nationalityOptions = $this->crawler->filter($fieldSelector);
        $randomNationality = $nationalityOptions->getNode(rand(1, count($nationalityOptions)-1));

        return $randomNationality->getAttribute('value');
    }
}
