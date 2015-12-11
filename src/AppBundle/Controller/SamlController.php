<?php
/**
 * Copyright 2015 SURFnet B.V.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace AppBundle\Controller;

use Exception;
use Surfnet\SamlBundle\Http\XMLResponse;
use Surfnet\SamlBundle\Metadata\MetadataFactory;
use Surfnet\SamlBundle\SAML2\Attribute\AttributeDefinition;
use Surfnet\SamlBundle\SAML2\Attribute\AttributeSet;
use Surfnet\SamlBundle\SAML2\Response\Assertion\InResponseTo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Session\Attribute\NamespacedAttributeBag;

class SamlController extends Controller
{
    /**
     * @var MetadataFactory
     */
    private $metadataFactory;
    /**
     * @var NamespacedAttributeBag
     */
    private $user;

    /**
     * @param MetadataFactory $metadataFactory
     */
    public function __construct(MetadataFactory $metadataFactory, NamespacedAttributeBag $user)
    {
        $this->metadataFactory = $metadataFactory;
        $this->user = $user;
    }
    public function consumeAssertionAction(Request $request)
    {
        $stateHandler = $this->get('app.saml.state_handler');
        $provider = $this->get('app.interactionprovider');

        $expectedInResponseTo = $stateHandler->getRequestId();

        try {
            $assertion = $provider->processSamlResponse($request);
        } catch (Exception $e) {
            throw new AuthenticationException('Unable to parse SAML Reponse. ' . $e->getMessage());
        }

        if (!InResponseTo::assertEquals($assertion, $expectedInResponseTo)) {
            $this->get('logger')->addAlert('Unexpected SAML response');
            throw new AuthenticationException('Unexpected SAML response');
        }

        $aSet = $this->get('surfnet_saml.saml.attribute_dictionary')
            ->translate($assertion)
            ->getAttributeSet();


        try {
            $nameId = $assertion->getNameId();
            $displayName = $this->getAttribute(
                $aSet,
                $this->get('saml.attribute.displayname')
            );
            $eduPPN = $this->getAttribute(
                $aSet,
                $this->get('saml.attribute.edupersonprincipalname')
            );
        } catch (Exception $e)
        {
            throw new AuthenticationException('Error in retrieving attributes');
        }

        // Set user info.
        $this->user->set('nameId', $nameId);
        $this->user->set('eduPPN', $eduPPN);
        $this->user->set('displayName', $displayName);

        return $this->redirectToRoute('index');
    }

    /**
     * @return XMLResponse
     */
    public function metadataAction()
    {
        return new XMLResponse($this->metadataFactory->generate());
    }

    /**
     * Get the attribute if exists.
     *
     * @param AttributeSet $attributeSet
     * @param AttributeDefinition $attributeDefinition
     * @return null|\Surfnet\SamlBundle\SAML2\Attribute\Attribute
     * @throws Exception
     */
    private function getAttribute(AttributeSet $attributeSet, AttributeDefinition $attributeDefinition)
    {
        if (!$attributeSet->containsAttributeDefinedBy($attributeDefinition))
        {
            throw new \Exception('Attribute not found.');
        }
        return $attributeSet->getAttributeByDefinition($attributeDefinition)->getValue();
    }
}
