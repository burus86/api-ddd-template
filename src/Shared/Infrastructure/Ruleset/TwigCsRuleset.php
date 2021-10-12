<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Ruleset;

use FriendsOfTwig\Twigcs\RegEngine\RulesetBuilder;
use FriendsOfTwig\Twigcs\RegEngine\RulesetConfigurator;
use FriendsOfTwig\Twigcs\Rule\ForbiddenFunctions;
use FriendsOfTwig\Twigcs\Rule\LowerCaseVariable;
use FriendsOfTwig\Twigcs\Rule\RegEngineRule;
use FriendsOfTwig\Twigcs\Rule\TrailingSpace;
use FriendsOfTwig\Twigcs\Rule\UnusedMacro;
use FriendsOfTwig\Twigcs\Rule\UnusedVariable;
use FriendsOfTwig\Twigcs\Ruleset\RulesetInterface;
use FriendsOfTwig\Twigcs\Validator\Violation;

/**
 * Class TwigCsRuleset
 * @package App\Shared\Infrastructure\Ruleset
 * @see https://github.com/friendsoftwig/twigcs/blob/master/doc/ruleset.md#creating-a-custom-ruleset
 */
class TwigCsRuleset implements RulesetInterface
{
    private $twigMajorVersion;

    public function __construct(int $twigMajorVersion)
    {
        $this->twigMajorVersion = $twigMajorVersion;
    }

    public function getRules(): array
    {
        $configurator = new RulesetConfigurator();
        $configurator->setTwigMajorVersion($this->twigMajorVersion);
        $builder = new RulesetBuilder($configurator);

        return [
            new ForbiddenFunctions(Violation::SEVERITY_ERROR, ['dump']),
            new LowerCaseVariable(Violation::SEVERITY_ERROR),
            new RegEngineRule(Violation::SEVERITY_ERROR, $builder->build()),
            new TrailingSpace(Violation::SEVERITY_ERROR),
            new UnusedMacro(Violation::SEVERITY_WARNING),
            new UnusedVariable(Violation::SEVERITY_WARNING),
        ];
    }
}
