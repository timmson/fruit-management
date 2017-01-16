<script type="text/javascript" language="javascript">
function HoverOverBox( ctrl )
{
    boxletter = ctrl.id.charAt( ctrl.id.length - 1 );
    ctrl.style.backgroundColor = '#898';
    HighlightMyLines( boxletter, true );
    MakeDetailVisible( boxletter, true );
}
function ExitBox( ctrl )
{
    boxletter = ctrl.id.charAt( ctrl.id.length - 1 );
    ctrl.style.backgroundColor = document.body.style.backgroundColor;
    HighlightMyLines( boxletter, false );
    MakeDetailVisible( boxletter, false );
}

function MakeDetailVisible( boxletter, onoff )
{
    did = "Detail" + boxletter;
    dctrl = document.getElementById( did );
    if( dctrl != null )
    {
        if( onoff )
            dctrl.style.visibility = "inherit";
        else
            dctrl.style.visibility = "hidden";
    }
}

function HighlightMyLines( boxletter, onoff )
{
    letters = "ABCDEFGHIJKL";
    changeset = ":";
    id = "Line";
    i = 0;
    for( i = 0; i < letters.length; i++ )
    {
        id = "Line" + letters.charAt(i) + boxletter;   /* + chr(i) + boxletter; */
        ctrl = document.getElementById( id );
        if( ctrl != null )
        {
            HighlightThisLine( ctrl, onoff );
            HighlightThisBox( letters.charAt(i), onoff );
        }
        id = "Line" + boxletter + letters.charAt(i);   /* + chr(i) + boxletter; */
        ctrl = document.getElementById( id );
        if( ctrl != null )
        {
            HighlightThisLine( ctrl, onoff );
            HighlightThisBox( letters.charAt(i), onoff );
        }
    }
}

function HighlightThisBox( boxletter2, onoff )
{
    bid = "Box" + boxletter2;
    bctrl = document.getElementById( bid );
    if( bid != null )
    {
        if( onoff )
            bctrl.style.backgroundColor = '#cdc';
        else
            bctrl.style.backgroundColor = document.body.style.backgroundColor;           
    }
}

function  HighlightThisLine( ctrl, onoff )
{
    clname = ctrl.className + "";
    clstyle = ctrl.style;
    if( onoff )
    {
        clstyle.borderColor = 'red';
        clstyle.borderStyle = 'solid';
    }        
    else
    {
        clstyle.borderColor = 'black';
        clstyle.borderStyle = 'dotted';
    }
}

</script>    

<div class="LineRightDown" id="LineAB"></div>
<div class="LineRightDown" id="LineAH"></div>
<div class="LineDown" id="LineAC"></div>
<div class="LineRightDown" id="LineCF"></div>
<div class="LineDown" id="LineCE"></div>
<div class="LineDown" id="LineCG"></div>
<div class="LineDown" id="LineDF"></div>
<div class="LineDown" id="LineEG"></div>
<div class="LineDownLeft" id="LineDG"></div>
<div class="LineDownLeft" id="LineDE"></div>
<div class="LineDownLeft" id="LineFE"></div>
<div class="LineDownLeft" id="LineFG"></div>
<div class="LineDownLeft" id="LineBH"></div>
<div class="LineDown" id="LineBI"></div>
<div class="LineDownRight" id="LineEH"></div>
<div class="LineLeftDown" id="LineEK"></div>
<div class="LineDownRight" id="LineEL"></div>
<div class="LineDown" id="LineFH"></div>
<div class="LineRightDown" id="LineFI"></div>
<div class="LineDownLeft" id="LineIH"></div>
<div class="LineDown" id="LineIL"></div>
<div class="LineDown" id="LineGK"></div>
<div class="LineDownRight" id="LineGJ"></div>
<div class="LineDownRight" id="LineGL"></div>
<div class="LineDownRight" id="LineGH"></div>
<div class="LineLeftDown" id="LineHK"></div>
<div class="LineRightDown" id="LineHL"></div>
<div class="LineLeftDown" id="LineJK"></div>
<div class="LineRightDown" id="LineJL"></div>
<div class="LineAcross" id="LineKL"></div>

<!-- onmouseover="this.className='BoxHover'"  onmouseout="this.className='Box'"  -->
<div class="Box" id="BoxA" onmouseover="javascript:HoverOverBox(this);" onmouseout="javascript:ExitBox(this);">On-site Customer</div>
<div class="Box" id="BoxB" onmouseover="javascript:HoverOverBox(this);" onmouseout="javascript:ExitBox(this);">Planning Game</div>
<div class="Box" id="BoxC" onmouseover="javascript:HoverOverBox(this);" onmouseout="javascript:ExitBox(this);">Metaphor</div>
<div class="Box" id="BoxD" onmouseover="javascript:HoverOverBox(this);" onmouseout="javascript:ExitBox(this);">40 Hour Week</div>
<div class="Box" id="BoxE" onmouseover="javascript:HoverOverBox(this);" onmouseout="javascript:ExitBox(this);">Refactoring</div>
<div class="Box" id="BoxF" onmouseover="javascript:HoverOverBox(this);" onmouseout="javascript:ExitBox(this);">Simple Design</div>
<div class="Box" id="BoxG" onmouseover="javascript:HoverOverBox(this);" onmouseout="javascript:ExitBox(this);">Pair Programming</div>
<div class="Box" id="BoxH" onmouseover="javascript:HoverOverBox(this);" onmouseout="javascript:ExitBox(this);">Testing</div>
<div class="Box" id="BoxI" onmouseover="javascript:HoverOverBox(this);" onmouseout="javascript:ExitBox(this);">Short Releases</div>
<div class="Box" id="BoxJ" onmouseover="javascript:HoverOverBox(this);" onmouseout="javascript:ExitBox(this);">Coding Standards</div>
<div class="Box" id="BoxK" onmouseover="javascript:HoverOverBox(this);" onmouseout="javascript:ExitBox(this);">Collective Ownership</div>
<div class="Box" id="BoxL" onmouseover="javascript:HoverOverBox(this);" onmouseout="javascript:ExitBox(this);">Continuous Integration</div>

<div class="Detail" id="DetailB">
<h4>The Planning Game</h4>
You couldn't possibly start development with only a rough plan.
You couldn't constantly update the plan - that would take too long and upset the customer.
Unless:
<ul>
<li>The customers did the updating of the plan themselves, based on estimates provided
by the programmers.</li>
<li>You had enough idea of a plan at the beginning to give the customers a rough idea
of what was possible over the next couple of years.</li>
<li>You made short releases so any mistake in the plan would have a few weeks or months
of impact at most.</li>
<li>Your customer was sitting with the team, so they could spot potential changes and
opportunities for improvement quickly.</li>
</ul>
Then perhaps you could start development with a simple plan, and continually refine 
it as you went along.
</div>

<div class="Detail" id="DetailI">
<h4>Short Releases</h4>
You couldn't possibly go into production after a few months.
You certainly couldn't make new releases of the system on cycles ranging from daily
to every couple of months. Unless:
<ul>
<li>The Planning Game helped you work on the most valuable stories, so even a small
system had business value.</li>
<li>You were integrating continuously, so the cost of packaging a release was minimal.</li>
<li>Your testing reduced the defect rate enough so you didn't have to go through a lengthy
testing cycle before allowing software to escape.</li>
<li>You could make a simple design, sufficient for this release, not for all time.</li>
</ul>
Then perhaps you could make small releases, soon after development begins.
</div>


<div class="Detail" id="DetailA">
<h4>On-site Customer</h4>
You couldn't possibly have a real customer on the team, sitting there full-time. They can 
produce far more value for the business elsewhere. 
Unless:
<ul>
<li>They can produce value for the project by writing functional tests.</li>
<li>They can produce value for the project by making small-scale priority and scope
decisions for the programmers.</li>
</ul>
Then perhaps they can produce more value for the company by contributing to the project.
Besides, if the team doesn't include a customer, they will have to add risk to the project 
by planning further in advance and coding without knowing exactly what tests they have to 
satisfy and what tests they can ignore.
</div>

<div class="Detail" id="DetailC">
<h4>Metaphor</h4>
You couldn't possibly start development with just a metaphor. There isn't enough detail there,
and besides, what if you're wrong?
Unless:
<ul>
<li>You quickly have concrete feedback from real code and tests about whether the metaphor is
working in practice.</li>
<li>Your customer is comfortable talking about the system in terms of the metaphor.</li>
<li>You refactor to continually refine your understanding of what the metaphor means in practice.</li>
</ul>
Then perhaps you could start development with just a metaphor.
</div>

<div class="Detail" id="DetailD">
<h4>40 Hour Week</h4>
You couldn't possibly work 40-hour weeks. You can't create enough business value in 40 hours.
Unless:
<ul>
<li>The Planning Game is feeding you more valuable work to do.</li>
<li>The combination of the Planning Game and testing reduces the frequency of nasty surprises,
where you have more to do than you thought.</li>
<li>The practices as a whole help you program at top speed, so there isn't any faster to go.</li>
</ul>
Then perhaps you could produce enough business value in 40-hour weeks. Besides, if the team doesn't
stay fresh and energetic, then they won't be able to execute the rest of the practices.
</div>

<div class="Detail" id="DetailE">
<h4>Refactoring</h4>
You couldn't possibly refactor the design of the system all the time. It would take too long,
it would be hard to control, and it would most likely break the system.
Unless:
<ul>
<li>You are used to collective ownership, so you don't mind making changes wherever they 
are needed.</li>
<li>You have coding standards, so you don't have to reformat before refactoring.</li>
<li>You program in pairs, so you are more likely to have the courage to tackle a tough
refactoring, and you are less likely to break something.</li>
<li>You have a simple design, so the refactorings are easier.</li>
<li>You have the tests, so you are less likely to break something without knowing it.</li>
<li>You have continuous integration, so if you accidentally break something at a distance,
or one of your refactorings conflicts with someone else's work, you know in a matter if hours.</li>
<li>You are rested, so you have more courage and are less likely to make mistakes.</li>
</ul>
Then perhaps you could refactor whenever you saw the chance to make the system simpler,
or reduce duplication, or communicate more clearly.
</div>

<div class="Detail" id="DetailF">
<h4>Simple Design</h4>
You couldn't possibly have just enough design for today's code. You would design
yourself into a corner and then you'd be stuck, unable to continue evolving the system. 
Unless:
<ul>
<li>You were used to refactoring, so making changes was not a worry.</li>
<li>You had a clear overall metaphor so you were sure future design changes would tend
to follow a convergent path.</li>
<li>You were programming with  a partner, so you were confident you were making a simple design,
not a stupid design.</li>
</ul>
Then perhaps you could get away with doing the best possible job of making a design for today.
</div>

<div class="Detail" id="DetailG">
<h4>Pair Programming</h4>
You couldn't possibly write all the production code in pairs. It will be too slow. What if two 
people don't get along?
Unless:
<ul>
<li>The coding standards reduce the picayune squabbles.</li>
<li>Everyone is fresh and rested, reducing further the changce of unprofitable ... uh ... discusssion.</li>
<li>The pairs write tests together, giving them a chance to align their understanding before
tackling the meat of the implementation.</li>
<li>The pairs have the metaphor to ground their decisions about naming and basic design.</li>
<li>The pairs are working within a simple design, so they can both understand what's going on.</li>
</ul>
Then perhaps you could write all the production code in pairs. Besides, if people program solo they are
more likely to make mistakes, more likely to overdesign, and more likely to blow off the other practices,
particularly under pressure.
</div>

<div class="Detail" id="DetailH">
<h4>Testing</h4>
You couldn't possibly write all those tests. It would take too much time. Programmers won't write tests. 
Unless:
<ul>
<li>The design is as simple as it can be, so writing tests isn't all that difficult.</li>
<li>You are programming with  a partner, so if you can't think of another test your partner can,
and if your partner feels like blowing off the tests, you can gently rip the keyboard away.</li>
<li>You feel good when you see the tests all running.</li>
<li>Your customer feels good about the system when they see all of their tests running.</li>
</ul>
Then perhaps programmers and customers will write tests. Besides, if you don't write automated tests,
the rest of XP doesn't work nearly as well.
</div>

<div class="Detail" id="DetailJ">
<h4>Coding Standards</h4>
You couldn't possibly ask the team to code to a common standard. Programmers are deeply individualistic,
and would rather quit than put their curly braces somewhere else.  
Unless:
<ul>
<li>The whole of XP makes them more likely to be members of a winning team.</li>
</ul>
Then perhaps they would be willing to bend their style a little. Besides, without coding standards the
additional friction slows pair programming and refactoring significantly.
</div>

<div class="Detail" id="DetailK">
<h4>Collective Ownership</h4>
You couldn't possibly have everybody potentially changing anything anywhere. Folks would be breaking stuff 
left and right, and the cost of integration would go up dramatically. 
Unless:
<ul>
<li>You integrate after a short enough time, so the chances of conflicts go down.</li>
<li>You write and run the tests, so the chance of breaking things accidentally goes down.</li>
<li>You pair program, so you are less likely to break code, and programmers learn faster what they 
can profitably change.</li>
<li>You adhere to coding standards, so you don't get into the dreaded Curly Brace Wars.</li>
</ul>
Then perhaps you could have anyone change code anywthere in the system when they see the chance to improve
it. Besides, without collective ownership the rate of evolution of the design slows dramatically.
</div>

<div class="Detail" id="DetailL">
<h4>Continuous Integration</h4>
You couldn't possibly integrate after only a few hours work. Integration takes far too long and there are too 
may conflicts and chances to break something. 
Unless:
<ul>
<li>You can run the test quickly so you know you haven't broken anything.</li>
<li>You program in pairs, so there are half as many streams of changes to integrate.</li>
<li>You refactor, so there are more smaller pieces, reducing the chance of conflicts.</li>
</ul>
Then perhaps you could integrate after a few hours. Besides, if you don't integrate quickly then the
chance of conflicts rises and the cost of integration goes up steeply.
</div>
