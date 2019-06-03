<?php

namespace SwagAdvDevBundle2\Components\Api\Resource;

use Shopware\Components\Api\Exception as ApiException;
use Shopware\Components\Api\Resource\Resource;
use Shopware\Models\Article\Article;
use SwagAdvDevBundle2\Models\Bundle as BundleModel;

class Bundle extends Resource
{
    /**
     * @param $offset
     * @param $limit
     * @param $filter
     * @param $sort
     *
     * @return array
     */
    public function getList($offset, $limit, $filter, $sort)
    {
        // todo Implement a QueryBuilder to read bundles
        $builder = $this->getBaseQuery();

        // The QueryBuilder should take $offset and $limit into account
        $builder->setFirstResult($offset)
            ->setMaxResults($limit);

        // Additional todo: The QueryBuilder should also be aware of $filter and $sort
        if (!empty($filter)) {
            $builder->addFilter($filter);
        }

        if (!empty($sort)) {
            $builder->addOrderBy($sort);
        }

        $query = $builder->getQuery();

        // Result list as object or array depending on $this->resultMode
        $query->setHydrationMode($this->getResultMode());

        //Paginator
        $paginator = $this->getManager()->createPaginator($query);

        $bundles = $paginator->getIterator()->getArrayCopy();
        $totalResult = $paginator->count();

        return ['data' => $bundles, 'total' => $totalResult];
    }

    /**
     * @param $id
     *
     * @throws ApiException\NotFoundException
     *
     * @return BundleModel
     */
    public function getOne($id)
    {
        // todo Implement the getOne method
        $builder = $this->getBaseQuery();

        $builder->where('bundle.id = :id')
            ->setParameter('id', $id);

        $query = $builder->getQuery();

        $query->setHydrationMode($this->getResultMode());

        $bundle = $query->getOneOrNullResult();

        if (!$bundle) {
            throw new ApiException\NotFoundException('Bundle with ID ' . $id . ' not found.');
        }

        // It should select the bundle with ID $id .
        // If the bundle does not exist, raise the exception ApiException\NotFoundException

        // Return the list as object or array depending on $this->resultMode

        return $bundle;
    }

    /**
     * @param $data
     *
     * @throws ApiException\ValidationException
     *
     * @return BundleModel
     */
    public function create($data)
    {
        // todo Implement the create method
        // - You can prepare the data $data using the `prepareBundleData`
        // - Create a bundle model
        // - Populate the bundle model with the `fromArray` method
        // - Save and return the model

        $data = $this->prepareBundleData($data);

        $bundle = new BundleModel();
        $bundle->fromArray($data);

        $violations = $this->getManager()->validate($bundle);

        if ($violations->count() >= 1) {
            throw new ApiException\ValidationException($violations);
        }

        $this->getManager()->persist($bundle);
        $this->flush();

        return $bundle;
    }

    /**
     * @param $id
     * @param array $data
     *
     * @throws ApiException\NotFoundException
     * @throws ApiException\ParameterMissingException
     * @throws ApiException\ValidationException
     *
     * @return BundleModel
     */
    public function update($id, array $data)
    {
        // todo implement the update method
        // - throw ApiException\ParameterMissingException, if $id was not provided
        if (!$id) {
            throw new ApiException\ParameterMissingException('No id given.');
        }
        // - Find the bundle with ID $id
        $bundle = $this->getManager()->find(\SwagAdvDevBundle2\Models\Bundle::class, $id);

        // - Throw the ApiException\NotFoundException, if not bundle with ID $id exists
        if (!$bundle instanceof \SwagAdvDevBundle2\Models\Bundle) {
            throw new ApiException\NotFoundException('Bundle with ID ' . $id . ' not found.');
        }
        // - Use `prepareBundleData` to prepare the bundle data
        $data = $this->prepareBundleData($data);

        // - Save the changes to the model
        $bundle->fromArray($data);
        $this->flush();

        // - return the model
        return $bundle;
    }

    /**
     * @param $id
     *
     * @throws ApiException\NotFoundException
     * @throws ApiException\ParameterMissingException
     */
    public function delete($id)
    {
        // todo implement the delete method
        // - Throw ApiException\ParameterMissingException, if there is no bundle ID $id
        if (!$id) {
            throw new ApiException\ParameterMissingException('No id given.');
        }

        // - Find the bundle with ID $id
        $bundle = $this->getManager()->find(\SwagAdvDevBundle2\Models\Bundle::class, $id);

        // - Throw the ApiException\NotFoundException, if not bundle with ID $id exists
        if (!$bundle instanceof \SwagAdvDevBundle2\Models\Bundle) {
            throw new ApiException\NotFoundException('Bundle with ID ' . $id . ' not found.');
        }

        $this->getManager()->remove($bundle);
        $this->flush();
    }

    /**
     * @param array $data
     *
     * @throws ApiException\NotFoundException
     *
     * @return array
     */
    protected function prepareBundleData(array $data)
    {
        // implement the `prepareBundleData` method
        // - the array $data['products'] should contain product entities instead of product IDs
        // - if an ID is missing, throw ApiException\NotFoundException
        // only do that if the array key 'products' exists

        if (!array_key_exists('products', $data)) {
            return $data;
        }

        $products = [];

        $em = $this->getManager();

        foreach ($data['products'] as $productId) {
            $product = $em->find(Article::class, $productId);
            if (!$product instanceof Article) {
                throw new ApiException\NotFoundException('Bundle with ID ' . $productId . ' not found.');
            }

            $products[] = $product;
        }

        $data['products'] = $products;

        return $data;
    }

    public function getBaseQuery()
    {
        $builder = $this->getManager()->createQueryBuilder();

        $builder->select(['bundle', 'products'])
            ->from(\SwagAdvDevBundle2\Models\Bundle::class, 'bundle')
            ->leftJoin('bundle.products', 'products');

        return $builder;
    }
}
