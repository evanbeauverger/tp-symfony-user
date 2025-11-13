<?php

namespace App\Tests\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\InMemoryUser;

final class ProductControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $productRepository;
    private string $path = '/product/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->productRepository = $this->manager->getRepository(Product::class);

        foreach ($this->productRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $testUser = new InMemoryUser('admin', 'password', ['ROLE_ADMIN']);
        $this->client->loginUser($testUser);

        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Product index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $testUser = new InMemoryUser('admin', 'password', ['ROLE_ADMIN']);
        $this->client->loginUser($testUser);

        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'product[label]' => 'Testing',
            'product[price_ht]' => 100,
            'product[price_tva]' => 20,
            'product[price_ttc]' => 120,
            'product[description]' => 'Testing',
        ]);

        //self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->productRepository->count([]));
    }
/*
    public function testShow(): void
    {
        $testUser = new InMemoryUser('admin', 'password', ['ROLE_ADMIN']);
        $this->client->loginUser($testUser);

        $fixture = new Product();
        $fixture->setLabel('My Title');
        $fixture->setPriceHt(100);
        $fixture->setPriceTva(20);
        $fixture->setPriceTtc(120);
        $fixture->setDescription('My Title');
        // $fixture->setCategories('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Product');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $testUser = new InMemoryUser('admin', 'password', ['ROLE_ADMIN']);
        $this->client->loginUser($testUser);

        $fixture = new Product();
        $fixture->setLabel('Value');
        $fixture->setPriceHt(100);
        $fixture->setPriceTva(20);
        $fixture->setPriceTtc(120);
        $fixture->setDescription('Value');
        // $fixture->setCategories('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'product[label]' => 'Something New',
            'product[price_ht]' => 100,
            'product[price_tva]' => 20,
            'product[price_ttc]' => 120,
            'product[description]' => 'Something New',
            //'product[categories]' => 'Something New',
        ]);

        //self::assertResponseRedirects('/product/');

        $fixture = $this->productRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getLabel());
        self::assertSame(100, $fixture[0]->getPriceHt());
        self::assertSame(20, $fixture[0]->getPriceTva());
        self::assertSame(120, $fixture[0]->getPriceTtc());
        self::assertSame('Something New', $fixture[0]->getDescription());
        //self::assertSame('Something New', $fixture[0]->getCategories());
    }

    public function testRemove(): void
    {
        $testUser = new InMemoryUser('admin', 'password', ['ROLE_ADMIN']);
        $this->client->loginUser($testUser);

        $fixture = new Product();
        $fixture->setLabel('Value');
        $fixture->setPrice_ht(100);
        $fixture->setPrice_tva(20);
        $fixture->setPrice_ttc(120);
        $fixture->setDescription('Value');
        //$fixture->setCategories('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/product/');
        self::assertSame(0, $this->productRepository->count([]));
    }*/
}
