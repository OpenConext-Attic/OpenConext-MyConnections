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

class SamlController extends Controller
{
    /**
     * @var MetadataFactory
     */
    private $metadataFactory;
    /**
     * @param MetadataFactory $metadataFactory
     */
    public function __construct(MetadataFactory $metadataFactory)
    {
        $this->metadataFactory = $metadataFactory;
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
            $displayName = $this->getAtribute($aSet, $this->get('saml.attribute.displayname'));
            $eduPPN = $this->getAtribute($aSet, $this->get('saml.attribute.edupersonprincipalname'));
            $uid = $this->getAtribute($aSet, $this->get('saml.attribute.uid'));
            $conextId = $this->getAtribute($aSet, $this->get('saml.attribute.surfconext.id'));
        } catch (Exception $e)
        {
            throw new AuthenticationException('Error in retrieving attributes');
        }

        $this->get('session')->set(
            'user',
            [
                'nameId'      => $nameId,
                'displayName' => $displayName,
                'eduPPN'      => $eduPPN,
                'uid'         => $uid,
                'conextUid'   => $conextId,
            ]
        );

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
     */
    private function getAtribute(AttributeSet $attributeSet, AttributeDefinition $attributeDefinition)
    {
        if ($attributeSet->containsAttributeDefinedBy($attributeDefinition))
        {
            return $attributeSet->getAttributeByDefinition($attributeDefinition)->getValue();
        }
        return NULL;
    }
}
