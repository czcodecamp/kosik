<?php
namespace AppBundle\Facade;
use AppBundle\Entity\Address;
use AppBundle\Entity\User;
use AppBundle\FormType\VO\AddressVO;
use AppBundle\FormType\VO\UserSettingsVO;
use AppBundle\Repository\AddressRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @author Vašek Boch <vasek.boch@live.com>
 * @author Jan Klat <jenik@klatys.cz>
 */
class UserFacade
{

	private $tokenStorage;
	private $authenticationUtils;
	private $entityManager;
	private $authenticationManager;
	private $addressRepository;

	public function __construct(
		TokenStorage $tokenStorage,
		AuthenticationUtils $authenticationUtils,
		EntityManager $entityManager,
		AuthenticationProviderManager $authenticationManager,
		AddressRepository $addressRepository
	) {
		$this->tokenStorage = $tokenStorage;
		$this->authenticationUtils = $authenticationUtils;
		$this->entityManager = $entityManager;
		$this->authenticationManager = $authenticationManager;
		$this->addressRepository = $addressRepository;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		if (null === $token = $this->tokenStorage->getToken()) {
			return;
		}

		if (!is_object($user = $token->getUser())) {
			return;
		}

		return $user;
	}

	/**
	 * @return null|AuthenticationException
	 */
	public function getAuthenticationError()
	{
		return $this->authenticationUtils->getLastAuthenticationError();
	}

	/**
	 * @return string
	 */
	public function getLastUsername()
	{
		return $this->authenticationUtils->getLastUsername();
	}

	/**
	 * @param UserSettingsVO $settingsVO
	 */
	public function saveUserSettings(UserSettingsVO $settingsVO)
	{
		if (!$this->getUser()) {
			throw new UnauthorizedHttpException("no user logged in");
		}

		$user = $this->getUser();
		$user->setFirstName($settingsVO->getFirstName())
			->setLastName($settingsVO->getLastName())
			->setPhone($settingsVO->getPhone());

		$this->entityManager->persist($user);
		$this->entityManager->flush([$user]);
	}

	public function editAddress(Address $address, AddressVO $addressVO)
	{
		$address->setFirstName($addressVO->getFirstName());
		$address->setLastName($addressVO->getLastName());
		$address->setStreet($addressVO->getStreet());
		$address->setCity($addressVO->getCity());
		$address->setPostCode($addressVO->getPostCode());
		$address->setPhone($addressVO->getPhone());

		$this->saveAddress($address);
	}

	public function saveAddress(Address $address)
	{
		$this->entityManager->persist($address);
		$this->entityManager->flush([$address]);
	}

	/**
	 * @param User $user
	 */
	public function saveUser(User $user)
	{
		$this->entityManager->persist($user);
		$this->entityManager->flush([$user]);
	}

	/**
	 * @param User $user
	 * @param int $addressId
	 * @return null|Address
	 */
	public function getUserAddress(User $user, $addressId)
	{
		return $this->addressRepository->findOneBy([
			"user" => $user,
			"id" => $addressId,
		]);
	}


}